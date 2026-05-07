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
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke tabel pelanggans dan pakets
        $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
        $table->foreignId('paket_id')->constrained('pakets')->onDelete('cascade');

        $table->integer('berat');
        $table->integer('total_harga');
        $table->date('tanggal_masuk');
        $table->date('tanggal_selesai');
        $table->string('status_pembayaran')->default('Belum Lunas');
        $table->string('status_cucian')->default('Dalam Proses');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
