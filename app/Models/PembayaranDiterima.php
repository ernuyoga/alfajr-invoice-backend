<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranDiterima extends Model
{
    protected $table = 'pembayaran_diterimas';

    protected $fillable = [
        'invoice_id',
        'jenis',
        'jumlah',
        'tanggal',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
