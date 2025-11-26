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
        Schema::table('ukuran_produk', function (Blueprint $table) {
            $table->boolean('is_rented')->default(false)->after('stok')->comment('Indicates if the size is currently rented');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ukuran_produk', function (Blueprint $table) {
            $table->dropColumn('is_rented');
        });
    }
};
