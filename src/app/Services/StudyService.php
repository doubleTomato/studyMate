<?php
// 스터디 기능에 필요한 서비스
namespace App\Services;
use App\Models\Studies;

use Illuminate\Support\Facades\Cache;


class StudyService
{
    // 정렬
    // 기준에 따라 (지역, 서치, 카테고리, 진행중인 것만, 페이징, 정렬(인기순, 최신순, 오래된 순))
    public function getOrderList(array $filters)
    {
        $query = Studies::query();


        // 카테고리
        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        // 지역
        if (!empty($filters['region'])) {
            $query->where('region_id', $filters['region']);
        }

        // 진행 상태 (진행중)
        if (!empty($filters['active']) && $filters['active'] === 'true') {
            $query->whereDate('deadline', '>=', now());
        }

        // 검색 (제목 + 설명)
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
            });
        }

        // 정렬
        switch ($filters['sort'] ?? 'latest') {
            case 'popular': // 인기순
                $query->orderBy('views', 'desc');
                break;
            case 'oldest': // 오래된 순
                $query->orderBy('created_at', 'asc');
                break;
            default: // 최신순
                $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($filters['pagination'] ?? 10);
    }
}
