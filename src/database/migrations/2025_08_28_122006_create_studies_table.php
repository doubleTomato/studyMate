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
        Schema::create('studies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->text('description');
            $table->string('title',255);
            $table->string('category',100);
            $table->string('location',100);
            $table->boolean('is_offline',255);
            $table->unsignedBigInteger('views');
            $table->unsignedBigInteger('max_members');
            $table->dateTime('end_dateitme');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studies');
    }
};
