<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Members;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection()->getPdo()->exec("SET NAMES 'utf8mb4'");
        $default_mem = [
            'name' => '홍길동',
            'password' => password_hash('1234#$%', PASSWORD_DEFAULT),
            'nickname' => '테스트',
            'email' => 'abc1234@gmail.com',
            'location' => '서울',
            'remember_token' => '',
            'email_verified_datetime' => now()
            
        ];
        Members::create($default_mem);
    }
}
