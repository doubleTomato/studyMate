{{-- 로그인 --}}
@extends('layouts.app')
@section('content')
     <div class="login-wrap">
        <img src="{{ asset('images/login_logo.png') }}" alt="Study Mate Logo" class="login-logo">
        <div class="login-info">
            <p>오늘의 <span class='msg'>스터디</span>를 시작해볼까요?</p>
        </div>
        <div class="login-form">
            <form>
                @csrf
                <input type="text" placeholder="아이디 또는 이메일">
                <input type="password" placeholder="비밀번호">
                <button type="submit" class="login-btn">로그인</button>
            </form>
        </div>
        <div class="links-container">
            <a href="#">아이디/비밀번호 찾기</a>
            <a href="{{ route('signup') }}">회원가입</a>
        </div>

        {{-- 추후 구현 예정 --}}
        {{--
        <div class="social-wrap">또는</div>
        
        <p class="social-login-title">소셜 계정으로 로그인</p>
        <div class="social-login-buttons">
            <a href="#" class="social-btn"><i class="fab fa-google"></i></a>
            <a href="#" class="social-btn"><i class="fab fa-kickstarter-k"></i></a> <a href="#" class="social-btn"><i class="fab fa-apple"></i></a>
        </div> --}}
    </div>
@endsection