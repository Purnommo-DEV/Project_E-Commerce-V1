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
            $table->foreignId('users_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('alamat_pengiriman_id')->constrained('alamat')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('kode_pesanan');
            $table->string('total_pembayaran');
            $table->string('total_berat');
            $table->string('metode_pembayaran')->nullable();
            $table->string('ekspedisi_layanan');
            $table->string('total_ongkir');
            $table->text('kode_pengiriman')->nullable();
            $table->string('orders_date');
            $table->string('expired_date');
            $table->text('bukti_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**rrr
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanan');
    }
};
