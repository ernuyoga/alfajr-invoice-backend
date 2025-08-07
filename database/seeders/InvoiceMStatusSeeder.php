<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceMStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('invoice_m_statuses')->insert([
            ['id' => 1, 'nama' => 'Lunas', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'Belum Lunas', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
