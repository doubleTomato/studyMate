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
            $table->renameColumn('location', 'region_id');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->tinyInteger('region_id') -> nullable(false) -> change();

            $table->tinyInteger('category_id') -> nullable() -> after('region_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            //
            $table->dropColumn('category_id');

            $table->renameColumn('region_id', 'location');
        });
    }
};
