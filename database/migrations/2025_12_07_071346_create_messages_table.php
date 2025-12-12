<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');    // id pengirim (user/admin)
            $table->unsignedBigInteger('receiver_id');  // id penerima (user/admin)
            $table->text('message');                    // isi pesan
            $table->boolean('is_read')->default(false);// status sudah dibaca
            $table->timestamps();                       // created_at & updated_at

            // opsional: foreign key kalau mau koneksi ke tabel users
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
