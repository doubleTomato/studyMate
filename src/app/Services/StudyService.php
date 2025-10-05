<?php
// 스터디 기능에 필요한 서비스
namespace App\Services;
use App\Models\Studies;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class StudyService
{
    // 정렬
    // 기준에 따라 (지역, 서치, 카테고리, 진행중인 것만, 페이징, 정렬(인기순, 최신순, 오래된 순))
    public function getOrderList(array $filters)
    {
        $query = Studies::query();

        Log::info('필터값 확인:', $filters);
        // 카테고리
        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
            Log::info('필터값 확인:', ['log' => 'category']);
        }

        // 지역
        if (!empty($filters['region'])) {
            $query->where('region_id', $filters['region']);
            Log::info('필터값 확인:', ['log' => 'region']);
        }

        // 진행 상태 (진행중)
        if (!empty($filters['active']) && $filters['active'] === 'true') {
            $query->whereDate('deadline_date', '>=', now());
            Log::info('필터값 확인:', ['log' => 'active']);
        }

        // 검색 (제목 + 설명)
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
            });
            Log::info('필터값 확인:', ['log' => 'search']);
        }

        // 정렬
        switch ($filters['sort'] ?? 'latest') {
            case 'popular': // 인기순
                $query->orderBy('views', 'desc');
                break;
            case 'deadline_date': // 마감 임박 순
                $query->orderBy('deadline_date', 'desc');
                break;
            case 'oldest': // 오래된 순
                $query->orderBy('created_at', 'asc');
                break;
            default: // 최신순
                $query->orderBy('created_at', 'desc');
        }

        Log::info('필터값 확인:', ['log' => 'pagination', 'pagination' => $filters['pagination']]);
        $returnVal = $query->paginate($filters['pagination'] === 1 ? 16 : $filters['pagination']);
        Log::info('필터값 확인:', ['log' => 'pagination', 'returnVal' => $returnVal]);

        return $returnVal;
    }

    public function buildTree($elements, $parentId= null){

        $returnVal = array();

        foreach($elements as $el){
            if($el -> parent_id == $parentId){
                $child_el = $this->buildTree($elements, $el->id);
                if($child_el){
                    $el->children = $child_el;
                }

                $returnVal[] = $el;
            }
        }
        return $returnVal;
    }


    public function viewCount($id){
        $study = Studies::find($id);
        $study_views = $study->views + 1;
        $study->update(['views'=>$study_views]);
    }
}
