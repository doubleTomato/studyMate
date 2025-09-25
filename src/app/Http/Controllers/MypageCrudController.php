<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;


use App\Models\Studies;
use App\Models\Members;
use App\Models\Study_members;
// use App\Services\LookupDbServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MypageCrudController extends Controller
{
    // protected LookupDbServices $lookupService;


    // public function __construct(LookupDbServices $lookupService)
    // {
    //     $this->lookupService = $lookupService;
    // }


    public function index(Request $request) // list page
    {
        // $study = Studies::with([
        // 'category:id,title',
        // 'region:id,name',
        // 'leader:id,name,nickname',
        // 'members:id,name,nickname'
        // ]) -> where('id',$id) -> first()?-> toArray();

       
        // return view('mypage.index', [ 'study' => $study, 'category' => $category, 'region' => $region ]);
        return view('mypage.index');
    }


    public function edit($id){
        // $data = array();
        // $study =  Studies::where('id', $id)->first()?->toArray();
        // $category =  $this -> lookupService -> getCategories();
        // $region = $this -> lookupService -> getRegions();
        // $leader = Members::where('id', $study['owner_id'])->first()->toArray();
        // //$participantsNum = Study_members::where('study_id', $id) -> get();
        // $participants = Study_members::leftjoin('members', 'study_members.member_id', '=', 'members.id') -> where('study_id', $study['id']) -> get();
        // $data = [
        //     'study' => $study,
        //     'category' => $category,
        //     'region' => $region,
        //     'leader' => $leader,
        //     'participants' => $participants -> toArray() // 참여자 수
        // ];
        // return view('mypage.edit', compact('data'));
        return view('mypage.edit');
    }


    public function update(Request $request, Studies $study): JsonResponse
    {
        try{
            $validateData = $request -> validate([
                'description' => 'required|string|max:1000',
                'titlename' => 'required|string|max:255',
                'category'=>'required|integer|min:0',
                'region'=>'nullable|integer|min:0',
                'recruited-num' => 'required|integer|min:0',
                'is-offline' => 'nullable|integer|min:0',
                'start-date' => 'required|date_format:Y-m-d',
                'end-date' => 'nullable|date_format:Y-m-d',
                'deadline-date' => 'required|date_format:Y-m-d',
                'location' =>'nullable|string|max:255'
            ], [], $request->all());
            $sendData = [
            'description' => $validateData['description'],
            'title' => $validateData['titlename'],
            'category_id' => $validateData['category'],
            'region_id' => $validateData['region'] ?? null,
            'max_members' => $validateData['recruited-num'],
            'is_offline' => $validateData['is-offline'] ?? 0,
            'start_date' => $validateData['start-date'],
            'end_date' => $validateData['end-date'] ?? null,
            'deadline' => $validateData['deadline-date'],
            'location' => $validateData['location'] ?? null,
            ];

            logger()->info('update 호출, $study 값:', ['study' => $study -> id]);
            $this_study = Studies::find($study -> id);
            $this_study -> update( $sendData );

            return response()->json([
                'msg' => '스터디가 성공적으로 수정되었습니다.',
                'id' => $this_study->id
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


     public function updateProfile(Request $request)
    {
        // (1) 먼저 기본적인 유효성 검사는 거치는 것이 좋습니다.
        $request->validate([
            'profile_image' => 'nullable|image|max:10240', // 10MB 정도로 넉넉하게 설정
        ]);
    
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
        
            // 파일 이름 생성 (중복 방지)
            $fileName = time() . '.' . $image->getClientOriginalExtension();
        
            // (3) Intervention Image를 사용하여 이미지 리사이징
            // 가로 300px 기준으로 비율에 맞게 리사이징
            $resizedImage = Image::make($image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        
            // 리사이징된 이미지를 storage에 저장
            // Storage::put() 메소드는 파일 내용과 경로를 인자로 받습니다.
            // toPng(), toJpeg() 등으로 포맷을 지정할 수 있습니다.
            Storage::put('public/profiles/' . $fileName, (string) $resizedImage->encode());
        
        
            // DB에 파일 경로 저장
            // 예시: Auth::user()->update(['profile_image_path' => 'profiles/' . $fileName]);
            $user = Auth::user();
            $user->profile_image_path = 'profiles/' . $fileName; // DB 컬럼에 경로 저장
            $user->save();
        }
    
    }

}
