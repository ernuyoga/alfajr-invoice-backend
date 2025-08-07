<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransportMJenisSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transport_m_jenis')->insert([
            ['id' => 1, 'nama' => 'Koper', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'Manasik', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'Pemberangkatan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nama' => 'Kepulangan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
