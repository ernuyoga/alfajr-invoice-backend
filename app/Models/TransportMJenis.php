<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportMJenis extends Model
{
    protected $table = 'transport_m_jenis';

    protected $fillable = [
        'nama',
    ];

    public function transports()
    {
        return $this->hasMany(Transport::class, 'transport_m_jenis_id');
    }
};
