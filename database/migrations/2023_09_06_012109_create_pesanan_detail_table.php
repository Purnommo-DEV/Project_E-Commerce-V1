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
        Schema::create('pesanan_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('pesanan_id')->constrained('pesanan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('produk_id')->constrained('produk')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('produk_detail_id')->constrained('produk_detail')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('kuantitas');
            $table->string('total_harga');
            $table->string('total_berat');
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
        Schema::dropIfExists('pesanan_detail');
    }
};
