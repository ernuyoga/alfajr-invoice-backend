<?php

namespace App\Services;

use App\Models\Invoice;
use App\Services\PaketService;
use App\Services\JamaahService;
use App\Services\TransportService;
use App\Services\PembayaranService;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    protected $jamaahService;
    protected $paketService;
    protected $transportService;
    protected $pembayaranService;

    public function __construct(
        JamaahService $jamaahService,
        PaketService $paketService,
        TransportService $transportService,
        PembayaranService $pembayaranService
    ) {
        $this->jamaahService = $jamaahService;
        $this->paketService = $paketService;
        $this->transportService = $transportService;
        $this->pembayaranService = $pembayaranService;
    }

    public function createInvoice(array $formData)
    {
        return DB::transaction(function () use ($formData) {
            // 1. Simpan Paket
            $paket = $this->paketService->createPaket([
                'nama'     => $formData['paket_nama'],
                'maskapai' => $formData['paket_maskapai'],
                'durasi'   => $formData['paket_durasi'],
                'tanggal'  => $formData['paket_tanggal'],
                'harga'    => $formData['paket_harga'],
            ]);

            // 2. Generate kode invoice (format: TRA + 6 digit angka urut)
            $lastInvoice = Invoice::orderBy('id', 'desc')->first();
            $lastNumber = $lastInvoice ? intval(substr($lastInvoice->kode, 3)) : 0;
            $newNumber = $lastNumber + 1;
            $kodeInvoice = 'TRA' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);

            // 3. Hitung total tagihan
            $jumlahJamaah = count($formData['jamaahs']);
            $hargaPaket   = $paket->harga;
            $totalTransport = 0;
            foreach ($formData['transports'] as $t) {
                $totalTransport += $t['harga'];
            }
            $totalTagihan = ($hargaPaket + $totalTransport) * $jumlahJamaah;

            // 4. Hitung total pembayaran diterima
            $totalBayar = 0;
            foreach ($formData['pembayarans'] as $p) {
                $totalBayar += $p['jumlah'];
            }
            $sisaBayar = $totalTagihan - $totalBayar;

            // 5. Simpan Invoice
            $invoice = Invoice::create([
                'paket_id'             => $paket->id,
                'invoice_m_status_id'  => $formData['status_id'],
                'kode'                 => $kodeInvoice,
                'tanggal'              => $formData['paket_tanggal'],
                'total_tagihan'        => $totalTagihan,
                'total_bayar'          => $totalBayar,
                'sisa_bayar'           => $sisaBayar,
            ]);

            // 6. Simpan Jamaah
            $this->jamaahService->saveJamaahs($invoice->id, $formData['jamaahs']);

            // 7. Simpan Transport
            $this->transportService->saveTransports($invoice->id, $formData['transports']);

            // 8. Simpan Pembayaran
            $this->pembayaranService->savePembayarans($invoice->id, $formData['pembayarans']);

            return $invoice;
        });
    }

    public function updateInvoice($invoiceId, array $formData)
    {
        return DB::transaction(function () use ($invoiceId, $formData) {
            $invoice = Invoice::findOrFail($invoiceId);

            // Update Paket
            $paket = $invoice->paket;
            $this->paketService->updatePaket($paket, [
                'nama'     => $formData['paket_nama'],
                'maskapai' => $formData['paket_maskapai'],
                'durasi'   => $formData['paket_durasi'],
                'tanggal'  => $formData['paket_tanggal'],
                'harga'    => $formData['paket_harga'],
            ]);

            // Update Jamaah
            $invoice->jamaahs()->delete();
            $this->jamaahService->saveJamaahs($invoice->id, $formData['jamaahs']);

            // Update Transport
            $invoice->transports()->delete();
            $this->transportService->saveTransports($invoice->id, $formData['transports']);

            // Hitung ulang total tagihan dan pembayaran
            $jumlahJamaah = count($formData['jamaahs']);
            $hargaPaket   = $paket->harga;
            $totalTransport = 0;
            foreach ($formData['transports'] as $t) {
                $totalTransport += $t['harga'];
            }
            $totalTagihan = ($hargaPaket + $totalTransport) * $jumlahJamaah;

            // Update Pembayaran
            $invoice->pembayaranDiterimas()->delete();
            $this->pembayaranService->savePembayarans($invoice->id, $formData['pembayarans']);
            $totalBayar = collect($formData['pembayarans'])->sum('jumlah');
            $sisaBayar = $totalTagihan - $totalBayar;

            // Update Invoice
            $invoice->update([
                'invoice_m_status_id' => $formData['status_id'],
                'tanggal'             => $formData['paket_tanggal'],
                'total_tagihan'       => $totalTagihan,
                'total_bayar'         => $totalBayar,
                'sisa_bayar'          => $sisaBayar,
            ]);

            return $invoice;
        });
    }

    public function deleteInvoice($invoiceId)
    {
        return DB::transaction(function () use ($invoiceId) {
            $invoice = Invoice::findOrFail($invoiceId);

            // Hapus relasi
            $invoice->jamaahs()->delete();
            $invoice->transports()->delete();
            $invoice->pembayaranDiterimas()->delete();

            // Hapus invoice
            $deletedData = $invoice->toArray();
            $invoice->delete();

            return $deletedData;
        });
    }

    public function getInvoiceById($id)
    {
        return Invoice::with([
            'paket',
            'invoiceMStatus',
            'jamaahs.jamaahMAwalan',
            'transports.transportMJenis',
            'pembayaranDiterimas'
        ])->findOrFail($id);
    }

    public function getAllInvoices()
    {
        return Invoice::with([
            'paket',
            'invoiceMStatus',
            'jamaahs.jamaahMAwalan',
            'transports.transportMJenis',
            'pembayaranDiterimas'
        ])->get();
    }
}
