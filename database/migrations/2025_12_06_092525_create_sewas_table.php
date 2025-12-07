<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sewa', function (Blueprint $table) {
            $table->id();

            // relasi ke users
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // relasi ke produk
            $table->unsignedBigInteger('produk_id');
            $table->foreign('produk_id')->references('id_produk')->on('produk')->onDelete('cascade');

            // detail sewa
            $table->string('ukuran')->nullable();
            $table->integer('jumlah')->default(1);

            // status sewa
            $table->enum('status', ['menunggu_konfirmasi', 'disewa', 'selesai'])->default('menunggu_konfirmasi');

            // tanggal
            $table->date('tanggal_sewa')->nullable();
            $table->date('tanggal_kembali')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sewa');
    }
};
