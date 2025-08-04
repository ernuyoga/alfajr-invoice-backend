<?php

namespace App\Services;

use App\Models\TransportMJenis;

class TransportMJenisService
{
    public function getAllJenis()
    {
        return TransportMJenis::all();
    }

    public function createJenis($nama)
    {
        return TransportMJenis::create([
            'nama' => $nama
        ]);
    }

    public function updateJenis(TransportMJenis $jenis, $nama)
    {
        $jenis->nama = $nama;
        $jenis->save();

        return $jenis;
    }

    public function deleteJenis(TransportMJenis $jenis)
    {
        $deletedData = $jenis->toArray();
        $jenis->delete();
        return $deletedData;
    }
}
