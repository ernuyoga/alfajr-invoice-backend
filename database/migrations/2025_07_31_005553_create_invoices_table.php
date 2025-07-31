<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id')->constrained('pakets')->onDelete('cascade');
            $table->foreignId('invoice_m_status_id')->constrained('invoice_m_statuses')->onDelete('cascade');
            $table->string('kode')->unique();
            $table->date('tanggal');
            $table->decimal('total_tagihan', 10, 0);
            $table->decimal('total_bayar', 10, 0);
            $table->decimal('sisa_bayar', 10, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
