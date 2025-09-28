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

        dd($request->all());

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


            // if($request->hasFile('profile_image')){
                $this -> updateProfile($request);
            // }
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


     protected function updateProfile(Request $request)
    {
        
        $request->validate([
            'profile_image' => 'nullable|image|max:10240', 
        ]);
    
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            
            //덮어쓰기 방지
            $fileName = time() . '.' . $image->getClientOriginalExtension();
        
            $resizedImage = Image::make($image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        
            Storage::put('public/profiles/' . $fileName, (string) $resizedImage->encode());
        

            $user = Auth::user();
            $user->profile_url = 'profiles/' . $fileName; // DB 컬럼에 경로 저장
            $user->save();
        }
    
    }

}
