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

        $verificationUrl = url('/verify-email?token=' . $user->verification_token);
        Mail::to($user->email)->send(new VerificationMail($user, $verificationUrl));

        return true
    }

    // 회원가입 처리
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'verification_token' => Str::random(32),
        ]);

        return redirect()->route('login') ->with('status');
    }

}
