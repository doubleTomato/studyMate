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

class MypageCrudController extends Controller
{
    protected LookupDbServices $lookupService;


    public function __construct(LookupDbServices $lookupService)
    {
        $this->lookupService = $lookupService;
    }


    public function index(Request $request) // list page
    {
        return view('mypage.index');
    }


    public function edit($id){
        $data = array();
        $member = Members::where('id', $id) -> first()->toArray();
        $category =  $this -> lookupService -> getCategories();
        $region = $this -> lookupService -> getRegions();
        $data = [
            'category' => $category,
            'region' => $region,
            'member' => $member,
        ];
        return view('mypage.edit', compact('data'));
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


            //$this_mem = Members::find($mypage -> id);
            $mypage->update($sendData);


            if($request->hasFile('profile_image')){
                $this -> updateProfile($request);
             }
            return response()->json([
                'msg' => '프로필이 성공적으로 수정되었습니다.',
                'id' => $mypage -> id,
                'state'=>'success'
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
            $study = Members::find($id);
            $study->delete();
        
            return response()->json([
                'msg' => '성공적으로 탈퇴 되었습니다.',
                'id' => '',
                'state'=>'success'
            ], 201);
        }
        catch(Exception $err){
            return response()->json([
            'msg' => '탈퇴에 실패했습니다. 다시 시도해주세요.',
            'err_msg' => $err->getMessage(),
            'state'=>'fail',
            logger()->error('탈퇴 실패', ['exception' => $err->getMessage()])
            ], 500);
        }
    }


     protected function updateProfile(Request $request)
    {
        // user 정보
        $user = Auth::user();

        $request->validate([
            'profile_image' => 'nullable|image|max:10240',
        ]);
        // origin 파일 경로
        $oldImagePath = $user->profile_url; 
        
        //현재 파일
        $uploadedFile = $request->file('profile_image');

        $fileName = $uploadedFile->hashName();

        $image_manager = new ImageManager(new Driver());
        $image = $image_manager->read($uploadedFile);
        $image->resize(300, 300);

        // 새 이미지 저장
        Storage::put('public/profiles/' . $fileName, (string) $image->encode());
        // test용
        // Storage::put('public/test_folder/' . $fileName, (string) $image->encode());
        
        // DB에 새 이미지 경로 업데이트
        $user->profile_url = 'profiles/' . $fileName;
        $user->save();

        // 새 이미지 성공적으로 저장 -> 기존 이미지 삭제
        if ($oldImagePath && Storage::exists('public/' . $oldImagePath)) {
            Storage::delete('public/' . $oldImagePath);
        }
    }
    
}
