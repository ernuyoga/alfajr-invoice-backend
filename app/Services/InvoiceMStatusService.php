<?php

namespace App\Services;

use App\Models\InvoiceMStatus;

class InvoiceMStatusService
{
    public function getAllStatus()
    {
        return InvoiceMStatus::all();
    }

    public function createStatus($nama)
    {
        return InvoiceMStatus::create([
            'nama' => $nama
        ]);
    }

    public function updateStatus(InvoiceMStatus $status, $nama)
    {
        $status->nama = $nama;
        $status->save();

        return $status;
    }

    public function deleteStatus(InvoiceMStatus $status)
    {
        $deletedData = $status->toArray();
        $status->delete();
        return $deletedData;
    }
}
