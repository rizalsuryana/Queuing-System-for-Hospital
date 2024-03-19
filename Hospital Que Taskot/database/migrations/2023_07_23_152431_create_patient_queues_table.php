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
        Schema::create('patient_queues', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('fk_doctor_id');
            $table->string('doctor_name');
            $table->uuid('fk_doctor_schedule_id');
            $table->uuid('fk_poli_id');
            $table->string('poli_name');
            $table->integer('quota');
            $table->time('start_time');
            $table->time('end_time')->nullable(true);
            $table->string('status');
            $table->timestamp('queue_at');
            $table->string('note')->nullable(true);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->foreign('fk_doctor_id')->references('id')->on('doctors');
            $table->foreign('fk_poli_id')->references('id')->on('polis');
            $table->foreign('fk_doctor_schedule_id')->references('id')->on('doctor_schedules');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_queues');
    }
};
