<?php

namespace App\Services;

use App\Models\Paket;

class PaketService
{
    public function createPaket(array $data)
    {
        return Paket::create([
            'nama' => $data['nama'],
            'maskapai' => $data['maskapai'],
            'durasi' => $data['durasi'],
            'tanggal' => $data['tanggal'],
            'harga' => $data['harga'],
        ]);
    }

    public function updatePaket(Paket $paket, array $data)
    {
        $paket->update($data);
        return $paket;
    }

    public function deletePaket(Paket $paket)
    {
        $deletedData = $paket->toArray();
        $paket->delete();
        return $deletedData;
    }

    public function getPaketById($id)
    {
        return Paket::findOrFail($id);
    }

    public function getAllPakets()
    {
        return Paket::all();
    }
}
