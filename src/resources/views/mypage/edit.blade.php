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
                        @if ($member['profile_url'])
                            {{-- 1. DB에 프로필 이미지 경로가 있는 경우 --}}
                            <img id="image_preview" src="{{ asset('storage/'. $member['profile_url']) }}" alt="프로필 이미지 미리보기" style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                            {{-- 2. DB에 프로필 이미지 경로가 없는 경우 (기본 이미지 표시) --}}
                            <img id="image_preview" src="{{ asset('images/default-profile.png') }}" alt="기본 프로필 사진">
                        @endif
                        
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
                            <div class="label">관심 분야<span class="helper-text">(선택)</span></div>
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
                <button class="cta-btn" type="button" onclick="profileUpdate(this.form, 'POST')">수정하기</button>
                {{-- <button type="submit">등록하기</button> --}}
            </div>
        </form>
        <div class="withdrawal-wrap">
            <p onclick="APP_FUNC.commonFunc.popupOpen('/modal/withdrawaluser/'+{{auth() -> id()}})">탈퇴하기</p>
        </div>
    </section>
@endsection

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('profile_image_input');
            const imagePreview = document.getElementById('image_preview');
                
            console.log(imageInput);
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
        });


    async function profileUpdate(f = null, methodType){

       
        const formData = methodType === 'POST' ? new FormData(f):null;
        
        if(methodType === 'POST'){
            const categoryId = $('#category-sel').val(); 
            const regionId = $('#region-sel').val();  
            const preferredTimeSlot = $('#preferred_time_slot').val();  
            
            if (categoryId) {
                formData.set('category', categoryId);
            }
            if (regionId) {
                formData.set('region', regionId);
            }
            if (preferredTimeSlot) {
                formData.set('preferred_time_slot', preferredTimeSlot);
            }


        }
        let msg = methodType === 'DELETE' ? '탈퇴가' : '프로필 수정이';


        APP_FUNC.commonFunc.modalOpen('alert', msg + ' 되는');
        
        fetch('/mypage/'+{{auth() -> id()}},{
            method: methodType,
            headers: {
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
            APP_FUNC.commonFunc.modalHide('alert');
            APP_FUNC.commonFunc.popupHide();
            if(data.state === 'success'){
                console.log("여기 안들어오는겨?");
                console.log(data.msg);
                let idVal = data.id === ''? '':"/"+data.id;
                APP_FUNC.commonFunc.modalOpen('alert-btn',data.msg,'btn-include');
                setTimeout(() => {
                    if(idVal !== ''){
                    window.location.href = `/mypage${idVal}/edit`;
                    
                    }else{
                     window.location.href = '/study';
                    }
                }, 2000);
            }else{
                console.log(data.errors)
            }
        })
        .catch(err => {
            console.log("실패:", err);
            APP_FUNC.commonFunc.modalOpen('alert-btn','실패', 'btn-include');
        });
    }


   
</script>

