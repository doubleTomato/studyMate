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
            // $table->string('category',100);
            $table->unsignedBigInteger('category_id'); //카테고리 id
            // $table->string('location',100);
            $table->boolean('is_offline',255); //온라인인 지 여부
            $table->unsignedBigInteger('region_id') -> nullable(); // 지역 id
            $table->string('location',255) -> nullable(); // 상세 위치
            $table->unsignedBigInteger('views'); // 조회수
            $table->unsignedBigInteger('max_members'); // 모집 인원
            $table->date('start_date'); // 모집 기간 시작
            $table->date('end_date') -> nullable(); // 모집 기간 끝 null일시 기간 제한 없음
            $table->date('deadline');
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
