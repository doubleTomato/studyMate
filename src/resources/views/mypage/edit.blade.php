@php
    ['category' => $category, 'region' => $region, 'member' => $member] = $data;
@endphp
@extends('layouts.app')
@section('content')
    <section class="mypage-sec">
        <form method="POST" action="/study/write">
            @csrf
            <div class="content-tit">
                <div>
                    <h1>나의 프로필</h1>
                    <div class="image-con">
                        <img id="image_preview" src="/images/default-profile.png" alt="프로필 이미지 미리보기" style="width: 200px; height: 200px; object-fit: cover;">
                        <label class="cm-btn" for="profile_image_input" title="프로필 사진 선택">
                            <i class="xi-pen"></i>
                        </label>
                        <input type="file" id="profile_image_input" name="profile_image" accept="image/*">
                    </div>
                    <ul class="info-list">
                        <li>
                            <div class="label">이름</div>
                            <div class="value">
                                 <input type="text" readonly name="name" value="{{ $member['name'] }}" placeholder="">
                            </div>
                        </li>
                        <li>
                            <div class="label">닉네임</div>
                            <div class="value">
                                 <input type="text" readonly name="nickname" value="{{ $member['nickname'] }}" placeholder="">
                            </div>
                        </li>
                         <li>
                            <div class="label">활동 지역</div>
                            <div class="value">
                                <div class="region-wrap">
                                    <select class="select2-basic" id="region-sel" name="region">
                                        <option value="">선택해주세요</option>
                                        @foreach($region as $key => $val)
                                            <option value="{{$val['id']}}" {{ $val['id'] == $member['region_id'] ? 'selected':''}}>
                                                {{ $val['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="label">관심 분야</div>
                            <div class="value">
                                <select class="select2-basic" id="category-sel" name="category" required>
                                    <option value="">선택해주세요</option>
                                    @foreach($category as $key => $val)
                                        <option value="{{$val['id']}}" {{ $val['id'] == $member['category_id'] ? 'selected':''}}>
                                            {{ $val['title'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        <li>
                            <div class="label">선호 시간대<span class="helper-text">(선택)</span></div>
                            <div class="value">
                                <select class="select2-basic" id="preferred_time_slot" name="preferred_time_slot">
                                    <option value="any">무관</option>
                                    <option value="morning">오전</option>
                                    <option value="afternoon">오후</option>
                                    <option value="weekend">주말</option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <div class="label">자기소개<span class="helper-text">(선택)</span></div>
                            <div class="value">
                                <textarea name="self-introduce" rows="3" 
                                placeholder="어떤 분야에 관심이 있는지, 어떤 목표를 가지고 있는지 알려주세요.
함께하고 싶은 스터디 방식이나 자신의 장점을 어필해도 좋아요.
자유롭게 자신을 소개해 주세요!"></textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            <div class="button-con">
                <a class="cm-btn" href="{{ route('study.index') }}">취소</a>
                <button class="cta-btn" type="button" onclick="APP_FUNC.commonFunc.sendData(this.form, 'POST')">수정하기</button>
                {{-- <button type="submit">등록하기</button> --}}
            </div>
        </form>
    </section>
    <script>
    // 1. id로 HTML 요소들을 가져옵니다.
    const imageInput = document.getElementById('profile_image_input');
    const imagePreview = document.getElementById('image_preview');

    // 2. 파일 인풋(imageInput)에 'change' 이벤트가 발생했을 때 실행될 함수를 설정합니다.
    imageInput.addEventListener('change', (event) => {
        // 사용자가 선택한 파일을 가져옵니다.
        const file = event.target.files[0];

        // 파일이 선택되었는지 확인합니다.
        if (file) {
            // FileReader 객체를 생성합니다.
            const reader = new FileReader();

            // 파일 읽기가 완료되었을 때 실행될 콜백 함수를 정의합니다.
            reader.onload = (e) => {
                // 읽어온 파일 데이터를 이미지 미리보기(imagePreview)의 src 속성에 할당합니다.
                imagePreview.src = e.target.result;
            };

            // FileReader가 파일을 읽도록 지시합니다.
            // 파일을 'Data URL' 형태로 읽어옵니다.
            reader.readAsDataURL(file);
        } else {
            // 파일 선택이 취소된 경우, 기본 이미지로 되돌릴 수 있습니다.
            imagePreview.src = "/images/default-profile.png";
        }
    });
</script>
@endsection