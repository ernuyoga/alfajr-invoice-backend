<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jamaah extends Model
{
    protected $table = 'jamaahs';

    protected $fillable = [
        'invoice_id',
        'jamaah_m_awalan_id',
        'nama',
    ];

    public function jamaahMAwalan()
    {
        return $this->belongsTo(JamaahMAwalan::class, 'jamaah_m_awalan_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
