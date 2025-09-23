{{-- 회원가입 --}}
@php
$location_names = [
'서울', '부산', '대구', '인천', '광주',
'대전', '울산', '세종', '경기', '강원',
'충북', '충남', '전북', '전남', '경북',
'경남', '제주'];
@endphp
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
        <h1>회원가입</h1>
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
                    <div id="code-wrap" style="display: none">
                        <input id="code-input" type="text" value="" placeholder="코드를 입력해주세요." name="code"/>
                        <button class="code-verification-btn" type="button" onclick="codeVerification(this)">인증하기</button>
                    </div>
                    <span class="msg" id="email-msg"></span>
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
                        <button type="button">중복확인</button>
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
            <button id="signup-send-btn" type="button" disabled onclick="signupSend(this)">다음으로</button>
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
    let isEmailVerified = false;


    const regEx = {
        // 이메일 형식 (일반적인 이메일 패턴)
        'email': /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/,

        // 이름 (오직 한글만, 2자 이상)
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
            'password': [(v.match(regEx.password) || []).length > 0, v.length > 8],
        }
    }




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
                    APP_FUNC.commonFunc.modalResponseHidden(res.msg, 'success');
                    $("#code-wrap").show();
            },
            error: function (xhr) {
                const errMessage = xhr.responseJSON.message || '오류가 발생했습니다.';
                APP_FUNC.commonFunc.modalResponseHidden(errMessage, 'fail');
            },
            complete: function() {
            }
        })
    }

    // typeV: 어떤 컬럼인지, v는 값
    function regExInputCheck(typeV, v){
        const regFunc = getRegFunc(v);
        
        if(Array.isArray(regFunc[typeV])){
            for(let i = 0; i < regFunc[typeV]; i++){
                if(!regFunc[type][i]){
                    return false;
                }
            }
        }else{
            return regFunc[typeV];
        }

        return true;

        // switch(typeV){
        //     case 'pw':
        //         if()
        //         $(`.${e}-msg`).text('공백이 포함 될 수 없습니다.');
        //         break;
        //     case 'pw_confirm':
        //         $(`.${e}-msg`).text('공백이 포함 될 수 없습니다.');
        //         break;
        //     case 'name':
        //         $(`.${e}-msg`).text('공백이 포함 될 수 없습니다.');
        //         break;
        //     case 'nicknam':
        //         $(`.${e}-msg`).text('공백이 포함 될 수 없습니다.');
        //         break;
        //     default;
        // }



    }

    function codeVerification(thisBtn){
         
        const emailInput = $("#email-input").val();
        const codeInput = $("#code-input").val();
        
        if(!codeInput) $("#email-msg").text("인증 코드를 입력해주세요.");
         

         $.ajax({
            url: "{{ route('email.verify.code') }}",
            method: "POST",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'), 
                'email': emailInput,
                'code': codeInput
            },
            success:function(res){
                isEmailVerified = true;
                let is_full = true;
                 $("#email-msg").text(res.msg).css('color','green');

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
                
            }

         })
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
        //if(is_full && isEmailVerified){
        if(is_full){
            $('#signup-send-btn').prop('disabled', false);
            $('#signup-send-btn').addClass('cta-btn');
        }else{
            $('#signup-send-btn').prop('disabled', true);
            $('#signup-send-btn').removeClass('cta-btn');
        }
    });


    function signupSend(thisBtn){
        $('input.req').each((i, e) => {
            const eName = $(e).attr('name');
            const eValue = $(e).val();
            //console.log(eName, eValue, regEx.space.test(eValue));
            
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
                     }
                     if(regExInputCheck(eName, eValue)){ 
                        $(`#pw-form`).addClass('err');
                    }else{
                        $(`#pw-length`).removeClass('err');
                        $(`#pw-form`).removeClass('err');
                    }
                }
                else if(!regExInputCheck(eName, eValue)){
                    console.log(i, '기본', eName, eValue);
                    $(`#${eName}-msg`).text(regMsg[eName]);
                    $(`#${eName}-msg`).addClass("err");
                }
                else{
                    console.log(i, 'else', eName, eValue);
                    $(`#${eName}-msg`).text('');
                    $(`#${eName}-msg`).removeClass("err");
                    
                }
            }
        });

            if($('input[name="password_confirmation"]').val() !== $("#password-input").val()){
                $("#password-confirm-msg").text('비밀번호가 일치하지 않습니다.');
                $("#password-confirm-msg").addClass("err");
            }else{
                $("#password-confirm-msg").removeClass("err");
            }

        //  $.ajax({
        //     url: "{{ route('email.verify.code') }}",
        //     method: "POST",
        //     data: {
        //         '_token': $('meta[name="csrf-token"]').attr('content'), 
        //         'email': emailInput,
        //         'code': codeInput
        //     },
        //     success:function(res){
        //         isEmailVerified = true;
        //          $("#email-msg").text(res.msg).css('color','green');

        //          // 인증 성공 시 이메일, 코드 입력창, 버튼들 비활성화
        //         $('#email-input').prop('readonly', true);
        //         $('#code-input').prop('readonly', true);
        //         $('.email-verification-btn').prop('disabled', true);
        //         $('.code-verification-btn').prop('disabled', true);
                
        //     }

        //  })
    }
//   });

</script>
@endsection
