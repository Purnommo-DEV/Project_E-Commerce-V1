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
        Schema::create('pesanan_status_log', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('pesanan_id')->constrained('pesanan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('status_pesanan_id')->constrained('pesanan_status_master')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('pesanan_status_log');
    }
};
