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
        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('no_kk')->unique();
            $table->uuid('kepala_keluarga_id')->nullable(); // optional
            $table->timestamps();

            $table->foreign('kepala_keluarga_id')->references('uuid')->on('customers')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_keluarga');
    }
};
