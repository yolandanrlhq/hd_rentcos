<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::table('testimonis', function (Blueprint $table) {
            $table->unsignedBigInteger('produk_id')->after('sewa_id');

            $table->foreign('produk_id')
                ->references('id_produk')->on('produk')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('testimonis', function (Blueprint $table) {
            $table->dropForeign(['produk_id']);
            $table->dropColumn('produk_id');
        });
    }
};
