<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceMStatus extends Model
{
    protected $table = 'invoice_m_statuses';

    protected $fillable = [
        'nama',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'invoice_m_status_id');
    }
}
