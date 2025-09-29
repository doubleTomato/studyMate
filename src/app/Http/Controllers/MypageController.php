<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;


// use App\Services\LookupDbServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\Studies;
use App\Models\Members;
use App\Models\Study_members;
use App\Services\LookupDbServices;

class MypageController extends Controller
{
    protected LookupDbServices $lookupService;


    public function __construct(LookupDbServices $lookupService)
    {
        $this->lookupService = $lookupService;
    }


    public function myStudy(Request $request){
        $category =  $this -> lookupService -> getCategories();
        $region = $this -> lookupService -> getRegions();


        $study = Studies::with([
        'category:id,title',
        'region:id,name',
        'leader:id,name',
        'members:id,name,profile_url'
        ])
        ->where('owner_id',auth()->id())
        ->paginate(16);

        if ($request->ajax()) {
            return view('common._list', compact('study'))->render();
        }

        return view('mypage.mystudy', [ 'study' => $study, 'category' => $category, 'region' => $region ]);
    }

    public function participation(Request $request){
        $category =  $this -> lookupService -> getCategories();
        $region = $this -> lookupService -> getRegions();


        $study = Studies::with([
        'category:id,title',
        'region:id,name',
        'leader:id,name',
        'members:id,name'
        ])
        ->leftJoin('study_members', 'studies.id','=', 'study_members.study_id')
        ->whereColumn('studies.owner_id','!=' ,'study_members.member_id')
        ->paginate(16);

        //$study_sql = $study -> toSql();
        //dd($study_sql);

        if ($request->ajax()) {
            return view('common._list', compact('study'))->render();
        }

        return view('mypage.participation', [ 'study' => $study, 'category' => $category, 'region' => $region ]);
    }

}
