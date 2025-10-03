<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StudyService;

use App\Models\Study_members;


class StudyController extends Controller
{
    protected $studyService;

    public function __construct(StudyService $studyService)
    {
        $this->studyService = $studyService;
    }

    public function getOrderList(Request $request)
    {
        $filters = $request->only([
            'category', 'region', 'active', 'search', 'sort', 'pagination'
        ]);

        $study = $this->studyService->getOrderList($filters);

        // return response()->json($data);
        return view('common._list', compact('study'))->render();
    }

    public function participationStudy(Request $request, $study_id){
         try{
            $save_data = [
                'study_id' => $study_id,
                'member_id' => auth()->id(),
                'rank' => '1',
                'join_datetime' => now()
            ];
            $study_member = Study_members::create($save_data);
        
            return response()->json([
                'msg' => '스터디에 성공적으로 <br/> 참여 신청 되었습니다.',
                'id' => ''
            ], 201);
        }
        catch(Exception $err){
            return response()->json([
            'msg' => '참여 신청이 실패했습니다. 다시 시도해주세요.',
            'err_msg' => $err->getMessage(),
            logger()->error('참여 신청이 실패', ['exception' => $err->getMessage()])
            ], 500);
        }
    }


    // 퇴장
     public function exitStudy(Request $request, $study_id){
         try{
          
            $study_member = Study_members::where('member_id',$study_id)->delete();
        
            return response()->json([
                'msg' => '스터디에서 성공적으로 <br/> 퇴장 되었습니다.',
            ], 201);
        }
        catch(Exception $err){
            return response()->json([
            'msg' => '퇴장이 실패했습니다. 다시 시도해주세요.',
            'err_msg' => $err->getMessage(),
            logger()->error('퇴장 신청이 실패', ['exception' => $err->getMessage()])
            ], 500);
        }
    }
}
