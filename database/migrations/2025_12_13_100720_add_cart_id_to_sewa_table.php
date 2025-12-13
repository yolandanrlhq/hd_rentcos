<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::table('sewa', function (Blueprint $table) {
            $table->unsignedBigInteger('cart_id')->nullable()->after('user_id');

            $table->foreign('cart_id')
                ->references('id')
                ->on('carts')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('sewa', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->dropColumn('cart_id');
        });
    }
};
