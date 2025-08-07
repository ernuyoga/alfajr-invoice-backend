<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Invoice;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class PDFGeneratorService
{
    public function generateInvoicePDFs(Invoice $invoice)
    {
        // Ambil data lengkap invoice
        $invoice = Invoice::with([
            'paket',
            'invoiceMStatus',
            'jamaahs.jamaahMAwalan',
            'transports.transportMJenis',
            'pembayaranDiterimas'
        ])->findOrFail($invoice->id);

        // Render HTML untuk customer
        $customerHtml = View::make('invoice_customer', compact('invoice'))->render();

        // Render HTML untuk admin
        $adminHtml = View::make('invoice_admin', compact('invoice'))->render();

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdfCustomer = new Dompdf($options);
        $dompdfAdmin = new Dompdf($options);

        // Generate PDF Customer
        $dompdfCustomer->loadHtml($customerHtml);
        $dompdfCustomer->setPaper('A4', 'portrait');
        $dompdfCustomer->render();
        $customerPdf = $dompdfCustomer->output();

        // Generate PDF Admin
        $dompdfAdmin->loadHtml($adminHtml);
        $dompdfAdmin->setPaper('A4', 'portrait');
        $dompdfAdmin->render();
        $adminPdf = $dompdfAdmin->output();

        $awalan = strtoupper($invoice->jamaahs->first()->jamaahMAwalan->nama ?? '');
        $jamaahTeratas = strtoupper($invoice->jamaahs->first()->nama ?? '');
        $namaPaket = strtoupper($invoice->paket->nama ?? '');
        $durasiPaket = strtoupper($invoice->paket->durasi ?? '');

        $bulanIndo = [
            1 => 'JANUARI', 2 => 'FEBRUARI', 3 => 'MARET', 4 => 'APRIL', 5 => 'MEI', 6 => 'JUNI',
            7 => 'JULI', 8 => 'AGUSTUS', 9 => 'SEPTEMBER', 10 => 'OKTOBER', 11 => 'NOVEMBER', 12 => 'DESEMBER'
        ];
        $carbonTanggal = Carbon::parse($invoice->tanggal);
        $tanggal = $carbonTanggal->day . ' ' . $bulanIndo[$carbonTanggal->month] . ' ' . $carbonTanggal->year;

        $baseFileName = strtoupper("{$invoice->kode} KWITANSI {$awalan} {$jamaahTeratas} {$namaPaket} {$durasiPaket}H KLOTER {$tanggal}") . '.pdf';

        $customerPath = "invoices/customer/{$baseFileName}";
        $adminPath = "invoices/admin/{$baseFileName}";

        Storage::put($customerPath, $customerPdf);
        Storage::put($adminPath, $adminPdf);

        return [
            'customer_pdf_path' => $customerPath,
            'admin_pdf_path' => $adminPath,
        ];
    }
}
