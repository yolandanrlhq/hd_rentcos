<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sewa_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sewa_id');
            $table->foreign('sewa_id')->references('id')->on('sewa')->onDelete('cascade');

            $table->unsignedBigInteger('produk_id');
            $table->foreign('produk_id')->references('id_produk')->on('produk')->onDelete('cascade');

            $table->string('ukuran');
            $table->integer('jumlah');
            $table->integer('harga_satuan');
            $table->integer('subtotal');

            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('sewa_items');
    }
};
