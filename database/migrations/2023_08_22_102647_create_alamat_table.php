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
        Schema::create('alamat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('alamat');
            $table->string('nama');
            $table->string('nomor_hp');
            $table->foreignId('provinsi_id')->constrained('idn_provinsi')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('kota_id')->constrained('idn_kota')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('alamat_utama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alamat');
    }
};
