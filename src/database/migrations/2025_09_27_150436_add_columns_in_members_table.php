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

        Schema::table('members', function (Blueprint $table) {

            $table->enum('preferred_time_slot', ['any', 'morning', 'afternoon', 'weekend'])
            ->default('any')
            ->comment('선호 시간대');
            $table->text("self_introduce")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('preferred_time_slot');
            $table->dropColumn('self_introduce');
        });

    }
};
