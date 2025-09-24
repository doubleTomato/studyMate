<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //로ㄱ인
    public function store(Request $request){
        $validate_data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($validate_data)){
            $request->session()->regenerate(); // 세션 재생성 하여 보안강화
            return redirect('/study');
        }

        return back()->withErrors([
            'email' => '이메일 또는 비밀번호가 <br/> 일치하지 않습니다.',
        ])->onlyInput('email');

    }

    // 로그아웃
    public function logout(Request $request):RedirectResponse{
        Auth::guard('web')->logout(); // Auth의 web방식 사용, 인증정보 삭제

        $request->session()->invalidate(); //현재 세션을 무효화 후 재사용 막기
        $request->session()->regenerateToken(); //CSRF 토큰 새로 발급

        return redirect('/study');
    }
}
