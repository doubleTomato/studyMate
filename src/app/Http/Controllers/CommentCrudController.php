<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

// 이미지 관련 외부라이브러리 intervention/image
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


// use App\Services\LookupDbServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\Studies;
use App\Models\Members;
use App\Models\Study_members;
use App\Services\LookupDbServices;
use Illuminate\Support\Facades\Auth;

class CommentCrudController extends Controller
{
    protected LookupDbServices $lookupService;


    public function __construct(LookupDbServices $lookupService)
    {
        $this->lookupService = $lookupService;
    }

    public function store(Request $request, Members $mypage): JsonResponse {
        
    }



    public function update(Request $request, Members $mypage): JsonResponse
    {

        // dd($request->all());
        // dd('update 메소드 실행됨', $request->all(), $request->hasFile('profile_image'));


        try{
            $validateData = $request -> validate([
                'self-introduce' => 'nullable|string',
                'category'=>'nullable|integer|min:0',
                'region'=>'required|integer|min:0',
                'preferred_time_slot' =>'nullable|string|max:255',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ], [], $request->all());
            $sendData = [
            'self_introduce' => $validateData['self-introduce'],
            'preferred_time_slot' => $validateData['preferred_time_slot'] ?? 'any',
            'category_id' => $validateData['category'] ?? null,
            'region_id' => $validateData['region'],
            ];


            $this_mem = Members::find($mypage -> id);
            $this_mem -> update($sendData);


            if($request->hasFile('profile_image')){
                $this -> updateProfile($request);
             }
            return response()->json([
                'msg' => '프로필이 성공적으로 수정되었습니다.',
                'id' => $this_mem->id
            ], 201); 
        
        }
        catch (ValidationException $e) {
            return response()->json([
                'msg' => '수정에 실패했습니다.',
                'errors' => $e->errors()
            ], 422);
        }
        catch(Exception $err){
            return response()->json([
            'msg' => '수정에 실패했습니다. 다시 시도해주세요.',
            'err_msg' => $err->getMessage(),
            logger()->error('업데이트 실패', ['exception' => $err->getMessage()])
        ], 500);

        }

        
    }

    //탈퇴하기
     public function destroy($id) {
        try{
            $study = Studies::find($id);
            $study->delete();
        
            return response()->json([
                'msg' => '스터디가 성공적으로 삭제 되었습니다.',
                'id' => ''
            ], 201);
        }
        catch(Exception $err){
            return response()->json([
            'msg' => '삭제에 실패했습니다. 다시 시도해주세요.',
            'err_msg' => $err->getMessage(),
            logger()->error('삭제 실패', ['exception' => $err->getMessage()])
            ], 500);
        }
    }

    
}
