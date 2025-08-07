<?php

namespace App\Services;

use App\Models\Hasil;

class HasilService
{
    public function createHasil(array $data)
    {
        return Hasil::create($data);
    }

    public function getAllHasil()
    {
        return Hasil::all();
    }

    public function getHasilById($id)
    {
        return Hasil::find($id);
    }

    public function updateHasil($id, $data)
    {
        $hasil = Hasil::find($id);
        if ($hasil) {
            $hasil->update($data);
        }
        return $hasil;
    }

    public function deleteHasil($id)
    {
        $hasil = Hasil::find($id);
        if ($hasil) {
            $hasil->delete();
            return true;
        }
        return false;
    }
}
