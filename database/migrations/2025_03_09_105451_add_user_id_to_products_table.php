<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // products tablosuna user_id alanı ekleniyor
            // user_id alanı, users tablosundaki id'ye referans verir
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Yabancı anahtar (foreign key) ve ilgili sütunu kaldırıyoruz
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
