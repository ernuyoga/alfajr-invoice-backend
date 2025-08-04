<?php

namespace App\Services;

use App\Models\JamaahMAwalan;

class JamaahMAwalanService
{
    public function getAllAwalan()
    {
        return JamaahMAwalan::all();
    }

    public function createAwalan($nama)
    {
        return JamaahMAwalan::create([
            'nama' => $nama
        ]);
    }

    public function updateAwalan(JamaahMAwalan $awalan, $nama)
    {
        $awalan->nama = $nama;
        $awalan->save();

        return $awalan;
    }

    public function deleteAwalan(JamaahMAwalan $awalan)
    {
        $deletedData = $awalan->toArray();
        $awalan->delete();
        return $deletedData;
    }
}
