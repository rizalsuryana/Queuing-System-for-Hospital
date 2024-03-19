<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->string('nik', 17);
            $table->string('phone', 20);
            $table->date('birth_date')->nullable(true);
            $table->string('address')->nullable(true);
            $table->char('gender', 1)->nullable(true);
            $table->string('bpjs_number', 25)->nullable(true);
            $table->uuid('fk_user_id');
            $table->foreign('fk_user_id')->references('id')->on('users')->nullable()->unsigned();;
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
