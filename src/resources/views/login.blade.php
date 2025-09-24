{{-- 로그인 --}}
@extends('layouts.app')
@section('content')
     <div class="login-wrap">
        <img src="{{ asset('images/login_logo.png') }}" alt="Study Mate Logo" class="login-logo">
        <div class="login-info">
            <p>오늘의 <span class='msg'>스터디</span>를 시작해볼까요?</p>
        </div>
        <div class="login-form">
            <form id="form-obj" method="POST" action="{{ route('login.post') }}" >
                @csrf
                <input id="id-input" type="text" value="{{ old('email') }}" name="email" placeholder="아이디 또는 이메일">
                <input id="pw-input" type="password" name="password" placeholder="비밀번호">
                <button id="login-btn" disabled type="submit" class="login-btn">로그인</button>
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
    <script type="text/javascript">
    const loginForm = document.getElementById('form-obj');
    const inputs = document.querySelectorAll("input");
    [...inputs].forEach((v) => {
        v.addEventListener('input', function(e){
            const idInput = document.getElementById("id-input").value;
            const pwInput = document.getElementById("pw-input").value;

            if(idInput.trim() !=='' && pwInput.trim() !== ''){
                $("#login-btn").prop('disabled', false);
                $("#login-btn").addClass("cta-btn");
            }else{
                $("#login-btn").prop('disabled', true);
                $("#login-btn").removeClass("cta-btn");
            }
        });
    });
     window.onload = function(){
        // console.log(inputs);
        loginForm.addEventListener('submit', function(e) {
            const isLoggedIn = myForm.dataset.isLoggedIn === 'true';
            const idInput = document.getElementById("id-input").value;
            const pwInput = document.getElementById("pw-input").value;
            if (idInput.trim() === '' && pwInput.trim() === '') {
                APP_FUNC.commonFunc.modalOpen('alert-btn','아이디나 비밀번호를 입력해주세요.','btn-include');
                e.preventDefault();
            }
        });

        @if ($errors->any())
            const errorMessages = @json($errors->all());
             APP_FUNC.commonFunc.modalOpen('alert-btn',errorMessages.join('\n'),'btn-include');
            //alert(errorMessages.join('\n'));
        @endif
    }
</script>
@endsection

