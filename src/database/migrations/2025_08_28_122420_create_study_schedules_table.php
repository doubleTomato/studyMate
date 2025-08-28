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
        Schema::create('study_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('study_id');
            $table->unsignedBigInteger('type');
            $table->enum('interval_days', [0,1,2,3,4,5,6]);
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_schedules');
    }
};
