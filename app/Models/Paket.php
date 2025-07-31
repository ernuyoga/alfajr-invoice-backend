<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'pakets';

    protected $fillable = [
        'nama',
        'maskapai',
        'durasi',
        'tanggal',
        'harga',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'paket_id');
    }
}
