<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;


use App\Models\Studies;
use App\Models\Members;
use App\Models\Study_members;
use App\Services\LookupDbServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudiesCrudController extends Controller
{
    protected LookupDbServices $lookupService;


    public function __construct(LookupDbServices $lookupService)
    {
        $this->lookupService = $lookupService;
    }


    public function index()
    {
        // 데이터베이스에서 모든 스터디를 가져옵니다.
        $studies = Studies::all();

        // 'studies.index' 뷰로 데이터를 전달하여 반환합니다.
        return view('study.index', ['studies' => $studies]);
    }

    public function store(Request $request): JsonResponse
    {
        try{
            DB::beginTransaction();
            $validateData = $request -> validate([
                'description' => 'required|string|max:1000',
                'titlename' => 'required|string|max:255',
                'category'=>'required|integer|min:0',
                'region'=>'nullable|integer|min:0',
                'recruited-num' => 'required|integer|min:0',
                'is-offline' => 'integer|min:0',
                'start-date' => 'required|date_format:Y-m-d',
                'end-date' => 'nullable|date_format:Y-m-d',
                'deadline-date' => 'required|date_format:Y-m-d',
                'location' =>'nullable|string|max:255'
            ]);
            $sendData = [
            'owner_id' => 1,
            'description' => $validateData['description'],
            'title' => $validateData['titlename'],
            'category_id' => $validateData['category'],
            'region_id' => $validateData['region'] ?? null,
            'max_members' => $validateData['recruited-num'],
            'is_offline' => $validateData['is-offline'],
            'start_date' => $validateData['start-date'],
            'end_date' => $validateData['end-date'] ?? null,
            'deadline' => $validateData['deadline-date'],
            'views' => 0,
            'location' => $validateData['location'] ?? null,
            ];
            $study = Studies::create($sendData);
            $study_mem_count = Study_members::where('study_id', $study -> id) -> count();

            $rank_val = $study_mem_count > 0 ? 0 : 1; // 멤버가 있을 시 일반 회원으로 저장

            // rank는 우짜지...
            Study_members::create(['study_id' => $study -> id,  'member_id' => 1, 'rank' => $rank_val, 'join_datetime' => now()]);
            
            DB::commit();

            return response()->json([
                'msg' => '스터디가 성공적으로 저장되었습니다.',
                'id' => $study->id
            ], 201); 
        
        }catch(Exception $err){
            return response()->json([
            'msg' => '저장에 실패했습니다. 다시 시도해주세요.',
            'err_msg' => $err->getMessage()
        ], 500);

        }

        
    }

    public function detail($id){
        $data = array();
        $study =  Studies::where('id', $id)->first()?->toArray();
        $category =  $this -> lookupService -> getCategories();
        $region = $this -> lookupService -> getRegions();
        $leader = Members::where('id', $study['owner_id'])->first()->toArray();
        //$participantsNum = Study_members::where('study_id', $id) -> get();
        $participants = Study_members::leftjoin('members', 'study_members.member_id', '=', 'members.id') -> where('study_id', $study['id']) -> get();
        $data = [
            'study' => $study,
            'category' => $category,
            'region' => $region,
            'leader' => $leader,
            'participants' => $participants -> toArray() // 참여자 수
        ];
        return view('study.detail', compact('data'));
    }
}
