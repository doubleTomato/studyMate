{{-- 회원가입 --}}

@extends('layouts.app')
@section('content')
@if ($errors->any())
    <div style="padding: 1rem; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 0.25rem; margin-bottom: 1rem;">
        <strong>문제가 발생했습니다!</strong>
        <ul style="margin-top: 0.5rem; margin-bottom: 0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="signup-sec">
    <div class="step step1-wrap active">
        <div class="title-wrap">
            <h1>회원가입</h1>
        </div>
        <form method="POST" action="#">
            @csrf
            <dl>
                <dt>
                    <label>E-mail</label>
                </dt>
                <dd>
                    <div>
                        <input id="email-input" class="req" type="text" value="" placeholder="이메일을 입력해주세요." name="email"/>
                        <button class="email-verification-btn" type="button" onclick="emailVerification(this)">인증하기</button>
                    </div>
                    <span class="msg" id="email-msg"></span>
                    <div id="code-wrap" style="display: none">
                        <input id="code-input" type="text" value="" placeholder="코드를 입력해주세요." name="code"/>
                        <button class="code-verification-btn" type="button" onclick="codeVerification(this)">인증하기</button>
                    </div>
                    <span class="msg" id="code-msg"></span>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label>Name</label>
                </dt>
                <dd>
                    <input id="name-input" class="req" type="text" value="" placeholder="이름을 입력해주세요." name="name"/>
                    <span class="msg" id="name-msg"></span>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label>NickName</label>
                </dt>
                <dd>
                    <div>
                        <input id="nickname-input" class="req" type="text" value="" placeholder="이름을 입력해주세요." name="nickname"/>
                        <button id="nickname-duplicate-btn" type="button" onclick="nicknameDuplicate()">중복확인</button>
                    </div>
                    <span class="msg" id="nickname-msg"></span>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label>활동 지역 선택</label>
                </dt>
                <dd>
                    <div>
                        <select id="region-sel" class="req select2-basic" name="region"/>
                            <option value="">활동 지역을 선택해주세요.</option>
                        </select>
                    </div>
                    <span class="msg" id="region-msg"></span>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label>Password</label>
                </dt>
                <dd>
                    <input id="password-input" class="req" type="password" value="" placeholder="비밀번호를 입력해주세요." name="password"/>
                    <ul class="helper-list">
                        <li id="pw-length">8자 이상</li>
                        <li id="pw-form">특수문자(!@#$%^&*()) 2개 이상 포함</li>
                        <li id="pw-space">공백 포함 불가</li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt>
                    <label>Confirm password</label>
                </dt>
                <dd>
                    <input id="password-confirm-input" type="password" value="" placeholder="비밀번호를 다시 입력해주세요."  name="password_confirmation"/>
                    <span class="msg" id="password-confirm-msg"></span>
                </dd>
            </dl>
            <button id="signup-send-btn" type="button" disabled onclick="signupSend(this, this.form)">다음으로</button>
        </form>
    </div>
</div>

<script>
$(document).ready(function () {  
    APP_FUNC.commonFunc.regionReturn('region-sel');
    $('.select2-basic').select2({
        width: '100%'
    });
});
    let isEmailVerified = false; //이메일 인증 확인
    let nicknameDuplicated = false; //닉네임 중복확인


    const regEx = {
        // 이메일 형식 (일반적인 이메일 패턴)
        'email': /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/,

        // 이름 (한글만, 2자 이상)
        'korean': /^[가-힣]+$/,

        // 닉네임 (특수문자, 공백 불가)
        // - 허용: 영문, 숫자, 한글
        'nickname': /^[a-zA-Z0-9가-힣]+$/,

        // 공백 제외
        'space': /\s/,

        // pw: 특수문자 2개이상 포함
        'password': /[!@#$%^&*(),.?":{}|<>]/g
    };

    const regMsg = {
        'email':'올바른 이메일 주소(예: example@email.com)를 입력해주세요.',
        'name':'한글만 입력하실 수 있습니다.',
        'nickname':'특수문자가 들어갈 수 없습니다.',
        'password':'특수문자가 2개이상 포함 되어야합니다.'
    }

    function getRegFunc(v){
        return regExFunc = {
            'email': regEx.email.test(v),
            'name': regEx.korean.test(v),
            'nickname':regEx.nickname.test(v),
            'password': (v.match(regEx.password) || []).length > 0,
        }
    }



    // 인증메일 보내기
    function emailVerification(thisBtn){
        const emailInput = $("#email-input").val();
        console.log(!emailInput);
        if(!emailInput){
            $("#email-msg").show();
            $("#email-msg").text("이메일을 입력해주세요.");
            return;
        }

        $("#email-msg").text('');

        $(thisBtn).prop('disabled',true).text('전송중..');

        $.ajax({
            url:'{{ route("email.send.code") }}',
            method:'POST',
            data:{
                '_token': $('meta[name="csrf-token"]').attr('content'), 
                'email':emailInput
            },
            success:function(res){
                if(res.status === 'duplicate'){
                    APP_FUNC.commonFunc.modalOpen('alert-btn', res.msg, 'btn-include');
                    $(thisBtn).prop('disabled',false).text('인증하기');
                    $("#email-msg").text(res.msg);
                }else{
                    APP_FUNC.commonFunc.modalResponseHidden(res.msg, 'success', 'mail');
                    $("#code-wrap").show();
                }
            },
            error: function (xhr) {
                const errMessage = xhr.responseJSON.message || '오류가 발생했습니다.';
                APP_FUNC.commonFunc.modalResponseHidden(errMessage, 'fail');
                console.log(errMessage);
            },
            complete: function() {
            }
        })
    }

    // typeV: 어떤 컬럼인지, v는 값
    function regExInputCheck(typeV, v){
        const regFunc = getRegFunc(v);
        return regFunc[typeV];
    }

    function codeVerification(thisBtn){
         
        const emailInput = $("#email-input").val();
        const codeInput = $("#code-input").val();
        
        if(!codeInput) $("#code-msg").text("인증 코드를 입력해주세요.");
         
        const dataToSend = {
            email: emailInput,
            code: codeInput
        };


        fetch('{{route("email.verify.code")}}',{
            method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                },
                body: JSON.stringify(dataToSend)
        })
        .then(res => {
            if(!res.ok){
                throw new Error("서버 에러 상태코드: "+res.status);
            }
            return res.json();
        })
        .then(data => {
            isEmailVerified = true;
            let is_full = true;
            $("#code-msg").text(data.msg).css('color','green');

            // 인증 성공 시 이메일, 코드 입력창, 버튼들 비활성화
            $('#email-input').prop('readonly', true);
            $('#code-input').prop('readonly', true);
            $('.email-verification-btn').prop('disabled', true);
            $('.code-verification-btn').prop('disabled', true);
            $('.req').each((i, e) => {
                if(!$(e).val()) is_full = false;
            });

            if(is_full){
                $('#signup-send-btn').prop('disabled', false);
                $('#signup-send-btn').addClass('cta-btn');
            }
        })
        .catch(err => {
            APP_FUNC.commonFunc.modalResponseHidden(err.message, 'fail');
        });
    }

    $('input').change((e) => {
        let is_full = true;
        $('.req').each((i,v) => {
            if($(v).val() === ''){
                $(`#${$(v).attr('name')}-msg`).text('');
                $(`#${$(v).attr('name')}-msg`).removeClass('err');
                is_full = false;
            }
            
        });
        if($("select[name='region']").val() === ''){
            is_full = false;
        }else{
            is_full = true;
        }

        if(is_full && isEmailVerified && nicknameDuplicated){
            $('#signup-send-btn').prop('disabled', false);
            $('#signup-send-btn').addClass('cta-btn');
        }else{
            $('#signup-send-btn').prop('disabled', true);
            $('#signup-send-btn').removeClass('cta-btn');
        }

    

    });
    

    //닉네임 중복체크
    function nicknameDuplicate(){
        const nickname = document.getElementById('nickname-input').value;
        if(nickname !== ''){
             $.ajax({
                url:'{{ route("signup.nickname") }}',
                method:'POST',
                data:{
                    '_token': $('meta[name="csrf-token"]').attr('content'), 
                    'nickname':nickname
                },
                success:function(res){
                    if(res.status !== 'success'){
                        $("#nickname-msg").addClass("err");
                        $("#nickname-duplicate-btn").prop("disabled", false);
                        $("#nickname-input").prop("readonly", false);
                    }else{
                        nicknameDuplicated  = true;
                        $("#nickname-msg").removeClass("err");
                        $("#nickname-msg").addClass("success");
                        $("#nickname-duplicate-btn").prop("disabled", true);
                        $("#nickname-input").prop("readonly", true);
                    }
                    $("#nickname-msg").text(res.msg);

                },
                error: function (xhr) {
                    const errMessage = xhr.responseJSON.message || '오류가 발생했습니다.';
                    console.log(errMessage);
                },
                complete: function() {
                }
            });
        }else{
            $("#nickname-msg").text('닉네임을 입력해주세요.');
            $("#nickname-msg").addClass("err");
        }
    }


    // 회원가입
    function signupSend(thisBtn, f){
        if($("select[name='region']").val() === ''){
            $("#region-msg").text('지역을 선택해주세요!');
        }else{
            let isOk = 0;
            $('input.req').each((i, e) => {
                const eName = $(e).attr('name');
                const eValue = $(e).val();

                if(regEx.space.test(eValue)){
                    if(eName !== 'password'){
                        $(`#${eName}-msg`).text('공백이 포함 될 수 없습니다.');
                        $(`#${eName}-msg`).addClass("err");
                    }else{
                        $("#pw-space").addClass('err');
                    }
                }else{
                    if(eName === 'password'){
                         $("#pw-space").removeClass('err');
                         if(eValue.length < 8){
                            $(`#pw-length`).addClass('err');
                         }else {
                            isOk += 1;
                            $(`#pw-length`).removeClass('err');
                         }
                         if(!regExInputCheck(eName, eValue)){ 
                            $(`#pw-form`).addClass('err');
                        }else{
                            $(`#pw-form`).removeClass('err');
                            isOk += 1;
                        }
                    }
                    else if(!regExInputCheck(eName, eValue)){
                        $(`#${eName}-msg`).text(regMsg[eName]);
                        $(`#${eName}-msg`).addClass("err");
                    }
                    else{
                        $(`#${eName}-msg`).text('');
                        $(`#${eName}-msg`).removeClass("err");
                        isOk += 1;
                    }
                }
            });

            if($('input[name="password_confirmation"]').val() !== $("#password-input").val()){
                $("#password-confirm-msg").text('비밀번호가 일치하지 않습니다.');
                $("#password-confirm-msg").addClass("err");
            }else{
                $("#password-confirm-msg").removeClass("err");
                isOk += 1;
            }

         
            //console.log(isOk);
            if(isOk === 6 && isEmailVerified && nicknameDuplicated){
                const formData = new FormData(f);
                const sendData = Object.fromEntries(formData.entries());

                fetch('{{route("signup.post")}}',{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                    },
                    body: JSON.stringify(sendData)
                })
                .then(res => {
                    return res.json();
                })
                .then(data => {
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        // alert("실패:" + data.message);
                        APP_FUNC.commonFunc.modalOpen('alert-btn', "실패: " + data.message, 'btn-include');
                    }

                })
                .catch(err => {
                    console.error("실패:", err);
                     APP_FUNC.commonFunc.modalOpen('alert-btn', "처리 중 오류가 발생했습니다.", 'btn-include');
                    // alert("처리 중 오류가 발생했습니다.");
                });
            }else{
                APP_FUNC.commonFunc.modalOpen('alert-btn', "입력되지 않은 항목이 있습니다. 모든 항목을 입력해주세요.", 'btn-include');
            }
        }
    }

</script>
@endsection
