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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->uuid('permission_uuid');
            $table->string('model_type');
            $table->uuid('model_uuid');

            $table->index(['model_uuid', 'model_type']);
            $table->foreign('permission_uuid')->references('uuid')->on('permissions')->onDelete('cascade');
        });

        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->uuid('role_uuid');
            $table->string('model_type');
            $table->uuid('model_uuid');

            $table->index(['model_uuid', 'model_type']);
            $table->foreign('role_uuid')->references('uuid')->on('roles')->onDelete('cascade');
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->uuid('permission_uuid');
            $table->uuid('role_uuid');

            $table->foreign('permission_uuid')->references('uuid')->on('permissions')->onDelete('cascade');
            $table->foreign('role_uuid')->references('uuid')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_etc');
    }
};
