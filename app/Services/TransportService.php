<?php

namespace App\Services;

use App\Models\Transport;

class TransportService
{
    public function saveTransports($invoiceId, array $transportDataList)
    {
        $savedTransports = [];
        foreach ($transportDataList as $data) {
            $transport = Transport::create([
                'invoice_id' => $invoiceId,
                'transport_m_jenis_id' => $data['transport_m_jenis_id'],
                'harga' => $data['harga'],
            ]);
            $savedTransports[] = $transport;
        }
        return $savedTransports;
    }

    public function getTransportsByInvoice($invoiceId)
    {
        return Transport::where('invoice_id', $invoiceId)->get();
    }

    public function updateTransport(Transport $transport, array $data)
    {
        $transport->update($data);
        return $transport;
    }

    public function deleteTransport(Transport $transport)
    {
        $deletedData = $transport->toArray();
        $transport->delete();
        return $deletedData;
    }
}
