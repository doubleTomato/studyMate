{{-- 회원가입 --}}
@php
$location_names = [
'서울', '부산', '대구', '인천', '광주',
'대전', '울산', '세종', '경기', '강원',
'충북', '충남', '전북', '전남', '경북',
'경남', '제주'];
@endphp
<!DOCTYPE html>
<html>
    @include('common.header')
    <body>
        <form action="/posts" method="POST">
            <section class="signup-sec">
                <nav>
                    <ul>
                        <li class="active">
                            <p>1</p>
                            <span>기본 정보 입력</span>
                        </li>
                        <li>
                            <p>2</p>
                            <span>닉네임 입력</span>
                        </li>
                        <li>
                            <p>3</p>
                            <span>지역 입력</span>
                        </li>
                    </ul>
                </nav>
                {{-- 기본정보 --}}
                <div class="step step1-sec active">
                    <div class="logo"></div>
                    <h1>회원가입</h1>
                    <dl>
                        <dt>
                            <label>E-mail</label>
                        </dt>
                        <dd>
                            <div>
                                <input class="req" type="text" value="" placeholder="이메일을 입력해주세요." name="email"/>
                                {{-- <a href="" style="display:inline-block; padding:10px 20px; background:#4CAF50; color:white; text-decoration:none;">인증하기</a> --}}
                            </div>
                            <span></span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>
                            <label>Name</label>
                        </dt>
                        <dd>
                            <input class="req" type="text" value="" placeholder="이름을 입력해주세요." name="username"/>
                            <span></span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>
                            <label>Password</label>
                        </dt>
                        <dd>
                            <input class="req" type="password" value="" placeholder="비밀번호를 입력해주세요." name="pw"/>
                            <i class=""></i>
                        </dd>
                    </dl>
                    <dl>
                        <dt>
                            <label>Confirm password</label>
                        </dt>
                        <dd>
                            <input class="req" type="password" value="" placeholder="비밀번호를 다시 입력해주세요."  name="confirm_pw"/>
                        </dd>
                    </dl>
                    <button type="button" onclick="APP_FUNC.commonFunc.requireConfirm(this)">다음으로</button>
                    {{-- <button type="button" onclick="testAlert()">다음으로</button> --}}
                </div>
                {{-- 닉네임 --}}
                <div class="step step2-sec">
                    <div class="icon"></div>
                    <dl>
                        <dt>
                            <h1>당신이 사용할 닉네임을 입력 해주세요!</h1>
                        </dt>
                        <dd>
                            <input type="text" value="" placeholder="닉네임을 입력해주세요."  name="confirm_pw"/>
                            <button type="button">중복확인</button>
                            <span></span>
                        </dd>
                    </dl>
                    <div class="suggested-nickname">
                        <h2>추천 닉네임(넣을지말지 고민중)</h2>
                        <ul class="lists">
                            <li>test12</li>
                            <li>test34</li>
                            <li>test56</li>
                            <li>test78910</li>
                            <li>테스트당신이사용할78910</li>
                            <li>test78910</li>
                        </ul>
                    </div>
                </div>
                {{-- 지역 --}}
                <div class="step step3-sec">
                    <div class="step3-sec-location">
                        <h1>지역 선택(중복선택 가능)</h2>
                        <ul>
                            @foreach($location_names as $key => $val)
                                <li>{{ $val }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button">회원가입 완료</button>
                </div>
            </section>
        </form>
        <script>
            // console.log(APP_FUNC);
        </script>
        {{-- @vite('resources/js/app.js')
        <script type="module">
            APP_FUNC.requireConfirm("fekjfelk");
        </script> --}}
    </body>
</html>
