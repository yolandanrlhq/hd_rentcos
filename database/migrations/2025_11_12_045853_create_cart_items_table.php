<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cart_items')) {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('id_produk');
            $table->string('ukuran')->nullable();
            $table->integer('jumlah')->default(1);
            $table->integer('harga_satuan');
            $table->timestamps();

            // Tambahkan foreign key di sini, tapi hati-hati kalau tabel tujuan belum ada
            // Contoh:
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            // $table->foreign('id_produk')->references('id')->on('produk')->onDelete('cascade');
        });
    }

    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
