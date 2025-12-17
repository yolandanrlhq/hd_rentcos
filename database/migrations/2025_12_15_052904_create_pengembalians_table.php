<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sewa_id')
                    ->references('id')
                    ->on('sewa')
                    ->onDelete('cascade')
                    ->unique();

            $table->date('tanggal_dikembalikan')->nullable();

            $table->enum('status', [
                'belum_dikembalikan',
                'dikembalikan',
                'dicek_admin',
                'selesai'
            ])->default('belum_dikembalikan');

            $table->integer('denda')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->string('bukti_foto')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
