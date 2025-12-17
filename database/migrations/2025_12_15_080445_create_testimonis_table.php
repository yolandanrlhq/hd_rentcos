<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sewa_id'); // harus sama dengan tipe Sewa.id
            $table->string('judul')->nullable();
            $table->text('isi');
            $table->tinyInteger('rating')->default(5); // misal 1-5
            $table->timestamps();

            // foreign key ke tabel sewa
            $table->foreign('sewa_id')
                  ->references('id')
                  ->on('sewa')
                  ->onDelete('cascade'); // kalau sewa dihapus, testimonial juga ikut
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonis');
    }
};
