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
        Schema::create('patient_queue_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('fk_patient_queue_id');
            $table->integer('queue_number');
            $table->uuid('fk_patient_id');
            $table->string('patient_name');
            $table->string('patient_bpjs_number')->nullable(true);
            $table->string('status');
            $table->timestamp('called_at')->nullable(true);
            $table->timestamp('in_room_at')->nullable(true);
            $table->timestamp('out_room_at')->nullable(true);
            $table->foreign('fk_patient_id')->references('id')->on('patients');
            $table->foreign('fk_patient_queue_id')->references('id')->on('patient_queues');
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
        Schema::dropIfExists('patient_queue_details');
    }
};
