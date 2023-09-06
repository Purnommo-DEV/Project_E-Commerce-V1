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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('kode_pesanan');
            $table->string('total_pembayaran');
            $table->string('total_berat');
            $table->string('metode_pembayaran')->nullable();
            $table->string('ekspedisi_layanan');
            $table->text('kode_pengiriman')->nullable();
            $table->string('orders_date');
            $table->string('expired_date');
            $table->text('bukti_pembayaran')->nullable();
            $table->string('status_pembayaran');
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
        Schema::dropIfExists('pesanan');
    }
};
