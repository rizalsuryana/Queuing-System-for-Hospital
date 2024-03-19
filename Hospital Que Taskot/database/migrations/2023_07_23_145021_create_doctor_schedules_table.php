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
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('fk_doctor_id');
            $table->uuid('fk_poli_schedule_id');
            $table->integer('quota');
            $table->time('start_time');
            $table->time('end_time')->nullable(true);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->foreign('fk_doctor_id')->references('id')->on('doctors');
            $table->foreign('fk_poli_schedule_id')->references('id')->on('poli_schedules');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
