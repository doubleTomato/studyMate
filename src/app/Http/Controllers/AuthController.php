<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Mail\VerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // 회원가입 폼 화면
    public function showRegisterForm()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    // 이메일 인증 처리
    public function verifyEmail(Request $request)
    {
        $token = $request->query('token');

        $verificationUrl = url('/verify-email?token=' . $member->verification_token);
        Mail::to($member->email)->send(new VerificationMail($member, $verificationUrl));

        return true
    }

    // 회원가입 처리
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'nickname' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $member = Members::create([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'location' => $request -> location
            'password' => bcrypt($request->password),
            'remember_token' => Str::random(32),
        ]);

        return redirect()->route('login') ->with('status','회원가입이 완료 되었습니다! 로그인을 진행 해주세요.');
    }

}
