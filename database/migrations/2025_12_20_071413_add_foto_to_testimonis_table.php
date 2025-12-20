<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonis', function (Blueprint $table) {

            // ➕ tambah kolom foto
            $table->string('foto')->nullable()->after('rating');

            // ❌ hapus kolom judul
            $table->dropColumn('judul');
        });
    }

    public function down(): void
    {
        Schema::table('testimonis', function (Blueprint $table) {

            // balikin kolom judul
            $table->string('judul')->nullable();

            // hapus kolom foto
            $table->dropColumn('foto');
        });
    }
};
