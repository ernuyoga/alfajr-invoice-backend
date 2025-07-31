<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamaahMAwalan extends Model
{
    protected $table = 'jamaah_m_awalans';

    protected $fillable = [
        'nama',
    ];

    public function jamaahs()
    {
        return $this->hasMany(Jamaah::class, 'jamaah_m_awalan_id');
    }
}
