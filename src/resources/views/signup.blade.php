{{-- 회원가입 --}}
@include('common.header')
<section>
    <nav>
        <ul>
            <li>
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
    <div class="step1-sec">
        <div class="logo"></div>
        <h1>회원가입</h1>
        <dl>
            <dt>
                <label>E-mail</label>
            </dt>
            <dd>
                <input type="text" value="" placeholder="이메일을 입력해주세요." name="email"/>
            </dd>
        </dl>
        <dl>
            <dt>
                <label>Name</label>
            </dt>
            <dd>
                <input type="text" value="" placeholder="이름을 입력해주세요." name="username"/>
            </dd>
        </dl>
        <dl>
            <dt>
                <label>Password</label>
            </dt>
            <dd>
                <input type="password" value="" placeholder="비밀번호를 입력해주세요." name="pw"/>
                <i class=""></i>
            </dd>
        </dl>
        <dl>
            <dt>
                <label>Confirm password</label>
            </dt>
            <dd>
                <input type="password" value="" placeholder="비밀번호를 다시 입력해주세요."  name="confirm_pw"/>
            </dd>
        </dl>
    </div>
    <div class="step2-sec">
        <div class="step2-sec-nickname">
            <div class="step2-icon"></div>
            <dl>
                <dt>
                    <label>당신이 사용할 닉네임을 입력 해주세요!</label>
                </dt>
                <dd>
                    <input type="password" value="" placeholder="비밀번호를 다시 입력해주세요."  name="confirm_pw"/>
                    <button type="button">-></button>
                </dd>
            </dl>
        </div>
        <div class="step2-sec-location">
            <h2>지역 선택</h2>
            <ul>
                <li></li>
            </ul>
        </div>
        <ul class="step2-nav">
            <li class="active"></li>
            <li></li>
        </ul>
    </div>
</section>
