<?php

namespace App\Services;

use App\Models\PembayaranDiterima;

class PembayaranService
{
    public function savePembayarans($invoiceId, array $pembayaranDataList)
    {
        $savedPembayarans = [];
        foreach ($pembayaranDataList as $data) {
            $pembayaran = PembayaranDiterima::create([
                'invoice_id' => $invoiceId,
                'jenis' => $data['jenis'],
                'jumlah' => $data['jumlah'],
                'tanggal' => $data['tanggal'],
            ]);
            $savedPembayarans[] = $pembayaran;
        }
        return $savedPembayarans;
    }

    public function getPembayaransByInvoice($invoiceId)
    {
        return PembayaranDiterima::where('invoice_id', $invoiceId)->get();
    }

    public function updatePembayaran(PembayaranDiterima $pembayaran, array $data)
    {
        $pembayaran->update($data);
        return $pembayaran;
    }

    public function deletePembayaran(PembayaranDiterima $pembayaran)
    {
        $deletedData = $pembayaran->toArray();
        $pembayaran->delete();
        return $deletedData;
    }
}
