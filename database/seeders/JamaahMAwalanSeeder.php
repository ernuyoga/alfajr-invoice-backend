<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JamaahMAwalanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jamaah_m_awalans')->insert([
            ['id' => 1, 'nama' => 'Bapak', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'Ibu', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'Saudara', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
