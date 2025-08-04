<?php

namespace App\Services;

use App\Models\Jamaah;

class JamaahService
{
    public function saveJamaahs($invoiceId, array $jamaahDataList)
    {
        $savedJamaahs = [];
        foreach ($jamaahDataList as $data) {
            $jamaah = Jamaah::create([
                'invoice_id' => $invoiceId,
                'jamaah_m_awalan_id' => $data['jamaah_m_awalan_id'],
                'nama' => $data['nama'],
            ]);
            $savedJamaahs[] = $jamaah;
        }
        return $savedJamaahs;
    }

    public function getJamaahsByInvoice($invoiceId)
    {
        return Jamaah::where('invoice_id', $invoiceId)->get();
    }

    public function updateJamaah(Jamaah $jamaah, array $data)
    {
        $jamaah->update($data);
        return $jamaah;
    }

    public function deleteJamaah(Jamaah $jamaah)
    {
        $deletedData = $jamaah->toArray();
        $jamaah->delete();
        return $deletedData;
    }
}
