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
        Schema::table('patient_queues', function (Blueprint $table) {
            $table->dropForeign('patient_queues_fk_doctor_id_foreign');
            $table->dropForeign('patient_queues_fk_doctor_schedule_id_foreign');
            $table->dropColumn('fk_doctor_id');
            $table->dropColumn('doctor_name');
            $table->dropColumn('fk_doctor_schedule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
