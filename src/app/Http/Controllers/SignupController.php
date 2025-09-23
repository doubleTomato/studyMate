<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Members;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class SignupController extends Controller
{

    public function signup(Request $request){
        $this -> validator($request->all())->validate(); //유효성 검사
        $member = $this->create($request->all()); // crate함수에 값 넘겨서 member생성
        Auth::login($member);
        return redirect()->intended('/study');
    }

   protected function create(array $data){
     // 세션에 저장된 인증된 이메일과 가입하려는 이메일이 일치하는지 확인
    if (session('verified_email') !== $data['email']) {
        // 일치하지 않으면 유효성 검사 예외를 발생시켜 가입을 막음
        throw ValidationException::withMessages([
            'email' => '이메일 인증이 필요합니다.',
        ]);
    }

    // 일치하면 사용자 생성 로직 진행
    $member = Member::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'nickname' => $data['nickname'],
        'region_id' => $data['region'],
    ]);

    // 회원가입 성공 후 세션 정보 삭제
    session()->forget('verified_email');

    return $member;
   }
}
