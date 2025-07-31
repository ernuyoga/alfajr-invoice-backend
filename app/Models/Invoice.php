<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'paket_id',
        'invoice_m_status_id',
        'kode',
        'tanggal',
        'total_tagihan',
        'total_bayar',
        'sisa_bayar',
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function invoiceMStatus()
    {
        return $this->belongsTo(InvoiceMStatus::class);
    }

    public function jamaahs()
    {
        return $this->hasMany(Jamaah::class, 'invoice_id');
    }

    public function transports()
    {
        return $this->hasMany(Transport::class, 'invoice_id');
    }

    public function pembayaranDiterimas()
    {
        return $this->hasMany(PembayaranDiterima::class, 'invoice_id');
    }

    public function hasils()
    {
        return $this->hasMany(Hasil::class, 'invoice_id');
    }
}
