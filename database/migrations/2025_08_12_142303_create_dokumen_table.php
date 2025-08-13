<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('public_id')->unique();
            $table->text('secure_url');
            $table->integer('ukuran')->nullable();
            $table->string('format')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('dokumen'); }
};
