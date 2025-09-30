<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::connection()->getPdo()->exec("SET NAMES 'utf8mb4'");
        $categories = [
            ['title' => '어학', 'description' => '영어, 일본어, 중국어 등 언어 학습 및 토익, 토플 같은 공인 어학 시험 준비'],
            ['title' => 'IT/개발', 'description' => '프로그래밍 언어, 앱/웹 개발, 데이터 분석 등 IT 기술 스터디'],
            ['title' => '취업/면접', 'description' => '자기소개서, 면접 연습, 포트폴리오 준비 등 취업 관련 스터디'],
            ['title' => '자격증', 'description' => '공인중개사, 기술 자격증, 컴퓨터 활용 능력 시험 등 자격증 취득 스터디'],
            ['title' => '고시/공무원', 'description' => '행정고시, 임용고시, 공무원 시험 등 각종 국가고시 준비'],
            ['title' => '독서', 'description' => '특정 책이나 분야를 함께 읽고 토론하는 독서 모임'],
            ['title' => '교양/취미', 'description' => '미술사, 심리학, 글쓰기, 영화 등 교양을 쌓거나 취미를 공유하는 스터디'],
            ['title' => '금융/재테크', 'description' => '주식, 부동산, 가계부 작성 등 재테크 관련 스터디'],
            ['title' => '면접', 'description' => '실전처럼 모의 면접을 진행하고 피드백을 주고받는 스터디'],
            ['title' => '공모전', 'description' => '팀을 꾸려 공모전 출품을 준비하는 스터디'],
        ];

        foreach ($categories as $category) {
            Categories::create($category);
        }
    }
}
