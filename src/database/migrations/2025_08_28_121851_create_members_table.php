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
            $table->string('nickname', 50);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->integer('region_id');
            $table->integer('category_id')->nullable();
            $table->enum('preferred_time_slot', ['any', 'morning', 'afternoon', 'weekend'])
            ->default('any')
            ->comment('선호 시간대');
            $table->text('self_introduce')->nullable();
            $table->string('profile_url', 2048)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->string('provider', 100)->nullable()->default('');
            $table->string('provider_id', 255)->nullable()->default('');
            $table->dateTime('email_verified_at')->nullable();
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
