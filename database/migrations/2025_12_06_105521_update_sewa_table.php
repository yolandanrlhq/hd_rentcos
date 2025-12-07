<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sewa', function (Blueprint $table) {
            $table->dropForeign(['produk_id']);
            $table->dropColumn('produk_id');
            $table->dropColumn('ukuran');
            $table->dropColumn('jumlah');

            $table->integer('total_harga')->default(0)->after('status');
        });
    }

    public function down()
    {
        Schema::table('sewa', function (Blueprint $table) {
            $table->unsignedBigInteger('produk_id');
            $table->string('ukuran')->nullable();
            $table->integer('jumlah')->default(1);

            $table->dropColumn('total_harga');
        });
    }
};
