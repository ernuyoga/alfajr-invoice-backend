<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $table = 'transports';

    protected $fillable = [
        'invoice_id',
        'transport_m_jenis_id',
        'harga',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function transportMJenis()
    {
        return $this->belongsTo(TransportMJenis::class, 'transport_m_jenis_id');
    }
}
