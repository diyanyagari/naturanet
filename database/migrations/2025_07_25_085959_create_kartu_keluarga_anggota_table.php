<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kartu_keluarga_anggota', function (Blueprint $table) {
            $table->id();
            $table->uuid('kartu_keluarga_id');
            $table->uuid('customer_id');
            $table->string('hubungan');
            $table->timestamps();

            $table->foreign('kartu_keluarga_id')->references('uuid')->on('kartu_keluarga')->cascadeOnDelete();
            $table->foreign('customer_id')->references('uuid')->on('customers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_keluarga_anggota');
    }
};
