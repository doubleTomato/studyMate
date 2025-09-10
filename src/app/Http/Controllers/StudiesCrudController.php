<?php

namespace App\Http\Controllers;

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

    public function write(Request $request): JsonResponse
    {
        $sendData = [
            'owner_id' => 1,
            'description' => $request -> input('ir1'),
            'title' => $request -> input('titlename'),
            'category_id' => (int)$request -> input('category'),
            'region_id' => (int)$request -> input('region'),
            'max_members' => (int)$request -> input('recruited-num'),
            'start_date' => $request -> input('deadline-date'),
            'is_offline' => (int)$request -> input('isOnline'),
            'end_date' => $request -> input('start-date'),
            'deadline' => $request -> input('end-date'),
            'views' => 0,
            'location' => $request -> input('location'),
        ];
        Studies::create($sendData);
        return response()->json(['msg'=>'성공!']);
    }

    public function detail($id){
        $data = array();
        $study =  Studies::where('id', $id)->first()?->toArray();
        $category =  $this -> lookupService -> getCategories();
        $region = $this -> lookupService -> getRegions();
        $leader = Members::where('id', $study['owner_id'])->first()->toArray();
        //$participantsNum = Study_members::where('study_id', $id) -> get();
        $participants = Study_members::leftjoin('members', 'study_members.member_id', '=', 'members.id') -> get();
        $data = [
            'study' => $study,
            'category' => $category,
            'region' => $region,
            'leader' => $leader,
            'participants' => $participants -> toArray() // 참여자 수
        ];
        return view('detail', compact('data'));
    }
}
