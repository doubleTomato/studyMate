<?php
// db에 저장된 상수 값을 가져오는 service
namespace App\Services;
use App\Models\Category;
use App\Models\Regions;

use Illuminate\Support\Facades\Cache;


class LookupDbServices
{
    //카테고리 전체 조회
    public function getCategories(): array
    {
        return Category::all()->toArray();
    }

    // 코드로 카테고리 조회
    public function getCategoryByCode(string $code): ?array
    {
        return Category::where('code', $code)->first()?->toArray();
    }

    // 지역 전체 조회
    public function getRegions(): array
    {
        return Regions::all()->toArray();
    }

    // 코드로 지역 조회
    public function getRegionsByCode(string $code): ?array
    {
        return Regions::where('code', $code)->first()?->toArray();
    }
}
