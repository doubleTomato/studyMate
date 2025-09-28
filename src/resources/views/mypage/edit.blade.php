@php
    ['category' => $category, 'region' => $region, 'member' => $member] = $data;
    $preferred_time_slot_arr = array("any" =>"무관","morning"=>"오전","afternoon"=>"오후","weekend"=>"주말");
@endphp
@extends('layouts.app')
@section('content')
    <section class="mypage-sec">
        <form method="POST" action="#"  enctype="multipart/form-data">
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
                                    <!-- <option value="any">무관</option> -->
                                    <!-- <option value="morning">오전</option> -->
                                    <!-- <option value="afternoon">오후</option> -->
                                    <!-- <option value="weekend">주말</option> -->
                                    @foreach($preferred_time_slot_arr as $key => $val)
                                        <option {{ $member['preferred_time_slot'] === $key ? 'selected':''}} value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        <li>
                            <div class="label">자기소개<span class="helper-text">(선택)</span></div>
                            <div class="value">
                                <textarea name="self-introduce" rows="3" 
                                placeholder="어떤 분야에 관심이 있는지, 어떤 목표를 가지고 있는지 알려주세요.
함께하고 싶은 스터디 방식이나 자신의 장점을 어필해도 좋아요.
자유롭게 자신을 소개해 주세요!">{{$member['self_introduce']}}</textarea>
                            </div>
                        </li>
                    </ul>
                </div>
            <div class="button-con">
                <a class="cm-btn" href="{{ route('study.index') }}">취소</a>
                <button class="cta-btn" type="button" onclick="profileUpdate(this.form, 'PUT')">수정하기</button>
                {{-- <button type="submit">등록하기</button> --}}
            </div>
        </form>
    </section>
    <script>
    const imageInput = document.getElementById('profile_image_input');
    const imagePreview = document.getElementById('image_preview');

    imageInput.addEventListener('change', (event) => {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        } else {
            imagePreview.src = "/images/default-profile.png";
        }
    });

    async function profileUpdate(f, methodType){
        // if(methodType === 'DELETE' && !confirm("정말 삭제하시겠습니까? 복구할 수 없습니다.")){
        // if(methodType === 'DELETE' && !(await APP_FUNC.commonFunc.confirmOpen())){
        //     return;
        // }
        // if (!f.checkValidity()) {
        //     alert("필수 값을 넣지 않았습니다. 입력값을 다시 확인해주세요!");
        //     return;
        // }
        // if($("#end-date").val() == '' && !$("#durationdisable").is(':checked')){
        //     alert("종료 일자를 선택해주시거나 기간 제한 없음을 선택해주세요!");
        //     return;
        // }if($("#region-sel").val() == '' && !$("#is-offline").is(":checked")){
        //     alert("지역을 선택해주시거나 온라인 제한을 선택해주세요!");
        //     return;
        // }
        const formData = new FormData(f);
        

        const categoryId = $('#category-sel').val(); 
        const regionId = $('#region-sel').val();  
        const preferredTimeSlot = $('#preferred_time_slot').val();  
        
        console.log(categoryId, regionId);

        if (categoryId) {
            formData.set('category', categoryId);
        }
        if (regionId) {
            formData.set('region', 3);
        }
        if (preferredTimeSlot) {
            formData.set('preferred_time_slot', preferredTimeSlot);
        }



        // $(".loading-sec").addClass('active');
        APP_FUNC.commonFunc.modalOpen('alert','프로필이 수정되는 중입니다.');
        // formData.append('_method', 'PUT');/
        // const sendData = Object.fromEntries(formData.entries());
        fetch('/mypage/'+{{auth() -> id()}},{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
            },
            // body: JSON.stringify(sendData)
            body: formData
        })
        .then(res => {
            return res.json();
        })
        .then(data => { 
            // alert("성공:" + data.msg);
            APP_FUNC.commonFunc.modalHide('alert');
            APP_FUNC.commonFunc.modalResponseHidden('프로필 수정이', 'response', 'success');
            // console.log(data);
            let idVal = data.id === ''? '':"/"+data.id;
            // window.location.href = `/mypage${idVal}/edit`;
        })
        .catch(err => {
            console.log("실패:", err);
            APP_FUNC.commonFunc.modalOpen('alert-btn','실패', 'btn-include');
        });
    }


</script>
@endsection