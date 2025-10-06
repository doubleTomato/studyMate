<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

// 이미지 관련 외부라이브러리 intervention/image
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


// use App\Services\LookupDbServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\Comments;
use App\Models\Members;
use App\Models\Notices;
use App\Services\LookupDbServices;
use Illuminate\Support\Facades\Auth;

class NoticeCrudController extends Controller
{
    protected LookupDbServices $lookupService;

    public function __construct(LookupDbServices $lookupService)
    {
        $this->lookupService = $lookupService;
    }

      public function index(Request $request) // list page
    {

        $notices = null;
        $study_id = $request -> query('id');
        if(!$study_id){
            return view('modal.notices.index');
        }else{
            $notices = Notices::where('study_id', $study_id)->orderBy('created_at','desc')->get();
        }
        return view('modal.notices.index', compact('notices'));
    }

    public function create(){
        return view('modal.notices.create');
    }

    public function store(Request $request, Members $mypage): JsonResponse {
         try{
            $member_id = auth()->id();
            $validateData = $request -> validate([
                'study_id' => 'required|integer|min:0',
                'title' => 'required|string|max:255',
                'content' => 'required|string|max:1000',
                'is_crucial' => 'nullable|integer|min:0',
            ]);
            $sendData = [
                'study_id' => $validateData['study_id'],
                'member_id' => $member_id,
                'title'=>$validateData['title'],
                'content' => $validateData['content'],
                'is_crucial'=>$validateData['is_crucial']??0,
            ];

            Notices::create($sendData);

            return response()->json([
                'msg' => '공지가 성공적으로 저장되었습니다.',
                'state' => 'success',
                'url' => '/study/'.$validateData['study_id']
            ], 201); 
    
        }catch(Exception $err){
            return response()->json([
            'msg' => '저장에 실패했습니다. 다시 시도해주세요.',
            'state' => 'fail',
            'err_msg' => $err->getMessage()
        ], 500);

        }


    }


    public function edit($id){
        $notices = Notices::find($id)->toArray();
        return view('modal.notices.edit', compact('notices'));
    }

    public function update(Request $request, Notices $notice): JsonResponse
    {
        try{
            $validateData = $request -> validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string|max:1000',
                'is_crucial' => 'nullable|integer|min:0'
            ], [], $request->all());
            $sendData = [
                'title'=>$validateData['title'],
                'content' => $validateData['content'],
                'is_crucial'=>$validateData['is_crucial']??0,
            ];

            $notice -> update($sendData);

            return response()->json([
                'msg' => '공지가 성공적으로 수정되었습니다.',
                'url'=>'/study/'.$notice->study_id,
                'state'=>'success'
            ], 201); 
        
        }
        catch (ValidationException $e) {
            return response()->json([
                'msg' => '수정에 실패했습니다.',
                'errors' => $e->errors(),
                'state'=>'fail'
            ], 422);
        }
        catch(Exception $err){
            return response()->json([
            'msg' => '수정에 실패했습니다. 다시 시도해주세요.',
            'err_msg' => $err->getMessage(),
            'state'=>'fail',
            logger()->error('업데이트 실패', ['exception' => $err->getMessage()])
        ], 500);

        }

        
    }

    //삭제하기
     public function destroy($id) {
        try{
            $notice = Notices::find($id);
            $study_id = $notice -> study_id;
            $notice->delete();
        
            return response()->json([
                'msg' => '성공적으로 공지가 삭제 되었습니다.',
                'id' => '',
                'url'=>'/study/'.$study_id,
                'state'=>'success'
            ], 201);
        }
        catch(Exception $err){
            return response()->json([
            'msg' => '삭제에 실패했습니다. 다시 시도해주세요.',
            'err_msg' => $err->getMessage(),
            'state'=>'fail',
            logger()->error('삭제 실패', ['exception' => $err->getMessage()])
            ], 500);
        }
    }

    
}
