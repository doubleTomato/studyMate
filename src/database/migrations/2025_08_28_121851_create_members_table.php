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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('password', 255);
            $table->string('nickname', 50)->default('');
            $table->string('email', 255);
            $table->string('location', 100)->default('');
            $table->string('profile_url', 2048)->nullable();
            $table->string('remember_token', 100);
            $table->string('provider', 100)->nullable()->default('');
            $table->string('provider_id', 255)->nullable()->default('');
            $table->dateTime('email_verified_datetime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
