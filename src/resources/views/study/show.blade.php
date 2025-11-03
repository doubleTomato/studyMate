@php
    use Carbon\Carbon;
    //dd($study);
    $today = new DateTime();
    $deadlineDate = DateTime::createFromFormat('Y-m-d',  $study['deadline_date']);
    $isClosed = $today > $deadlineDate || count($study['members']) === $study['max_members'];

    $is_participation_arr = array_column($study['members'], 'id');

    $is_participation = auth()->check() ? in_array(Auth::user()->id, $is_participation_arr):false;
    

    $d_day = $deadlineDate -> diff($today);
    $d_day_val = '';
    $d_day_class = "cm-label ";
    if((int)$d_day -> format('%R%a') === 0){
        $d_day_val = 'Today';
        $d_day_class .= "today";
    }
    else if($d_day -> invert === 0){
        $d_day_val = '마감';
        $d_day_class .= "deadline";
    }else{
        $d_day_val = '진행중';
        $d_day_class .= "progress";
    }

    //dd(Auth::user());

@endphp
{{-- 스터디 모집 글 상세 --}}
@extends('layouts.app')
@section('content')
{{-- dd($study) --}}
<section class="detail-sec">
    <div class="flex-wrap title-wrap">
        <h1><span class="{{ $d_day_class }}"> {{ $d_day_val }}</span> {{ $study['title'] }}</h1>
        @if(auth()->check() && !$isClosed && Auth::user()->id !== $study['owner_id']&&!$is_participation)
        <button onclick="participationStudy({{$study['id']}})" type="button" class="icon-btn plus-user cta-btn">
            <i class="xi-user-plus"></i>
            <span>참여하기</span>
        </button>
        @elseif(auth()->check() && Auth::user()->id !== $study['owner_id'] && $is_participation)
            <button onclick="participationStudy({{$study['id']}},'exit')" type="button" class="icon-btn delete-btn">
                <span>퇴장하기</span>
            </button>
        @endif
    </div>
    {{-- 공지 --}}
    <div class="notice-wrap-box">
        <div class="flex-wrap">
            @if(!$notices)
            <p><i class="xi-flag"></i> 등록된 공지가 없습니다.</p>
            @else
            <div class="notice-wrap" onclick="APP_FUNC.commonFunc.popupOpen('/notice/{{$notices['id']}}/edit')">
                <div class="notice-title">
                    <p>
                        @if($notices['is_crucial'] === 1)
                        <span class="important-txt cm-label important">필독 !</span>
                        @endif
                        {{$notices['title']}} <i title="자세히보기" class="xi-zoom-in xi-1x"></i></p>
                </div>
            </div>
            @endif
            <div class="btn-wrap">
                @if(auth()->check() && Auth::user()->id === $study['owner_id'])
                <button type="button" onclick="APP_FUNC.commonFunc.popupOpen('/notice/create')"><i class="xi-plus-circle"></i> 추가</button>
                @endif
                <p onclick="APP_FUNC.commonFunc.popupOpen('/notice?id={{$study['id']}}')">전체보기<i class="xi-angle-right-min"></i></p> 
            </div>
        </div>
    </div>
    {{--// 공지 end --}}
    <div class="flex-wrap header-wrap">
        <div class="header-con">
            <p><i class="xi-crown"></i><span class="leader">{{ $study['leader']['nickname'] }}</span><span class="helper-text">{{  Carbon::parse($study['updated_at']) ->format('Y.m.d H:i')  }}</span></p>
        </div>
        <div class="button-con">
            <a class="cm-btn" href="{{ route('study.index') }}">목록으로</a>
            @if(!$isClosed && auth()->check() && Auth::user()->id === $study['owner_id']) 
                <a class="cm-btn" href="{{ route('study.edit', $study['id']) }}">수정하기</a>
            @endif
        </div>
    </div>
    <div class="flex-wrap right delete-btn-wrap">
        <form method="POST" action="#">
            @method('DELETE')
            @csrf
            @if(!$isClosed && auth()->check() && Auth::user()->id === $study['owner_id'])
                <button type="button" onclick="APP_FUNC.commonFunc.sendData(this.form, 'DELETE', '/{{$study['id']}}')" class="cm-btn delete-btn">삭제하기</button>
            @endif
        </form>
    </div>
    <hr/>
    <div class="content-tit">
        <div class="detail-content information">
            <h2>1. 기본 정보</h2>
            <ul class="info-list">
                <li>
                    <div class="label">카테고리</div>
                    <div class="value">
                        {{ $study['category']['title'] }}
                    </div>
                </li>
                <li>
                    <div class="label">모집 인원</div>
                    <div class="value">
                        <div class="members-count participants-count">
                            <div class="progress-bar">
                                <div class="progress" style="width: {{ (100 / $study['max_members']) * (count($study['members']) - 1) }}%"></div>
                                <div>
                                    <span>{{ count($study['members']) - 1 }}</span>
                                    <span>/</span>
                                    <span>
                                        {{ $study['max_members'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="members-list">
                            <div>
                                <a class="cm-btn" title="참여멤버전체보기" href="#member-lists">참여멤버전체보기</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="label">모집 마감일<i class="xi-calendar"></i></div>
                    <div class="value">
                        {{ $study['deadline_date'] }}
                    </div>
                </li>
                <li>
                    <div class="label">스터디 기간<i class="xi-calendar"></i></div>
                    <div class="value">
                        <div class="datetime-wrap">
                            @if(!empty($study['end_date']))
                                <span>{{ $study['start_date'] }}</span>
                                <span>~</span>
                                <span>{{$study['end_date']}}</span>
                            @else
                                (<label for="durationdisable">기간 제한 없음</label>)
                            @endif
                        </div>
                    </div>
                </li>
                <li>
                    <div class="label">지역</div>
                    <div class="value">
                        <div class="region-wrap">
                            @if($study['is_offline'] === 0)
                                {{ $study['region']['name'] }}
                            @else
                                온라인 진행
                            @endif
                        </div>
                    </div>
                </li>
                <li>
                    <div class="label">상세 주소</div>
                    <div class="value">{{ $study['location'] }}</div>
                </li>
            </ul>
        </div>
        <div class="write-content detail">
            <h2>2. 세부 내용</h2>
            <textarea style="width: 100%" name="ir1" id="ir1" rows="10" cols="100" readonly>
                {{ $study['description'] }}
            </textarea>
        </div>
        <div id="member-lists" class="write-content detail">
            <h2>3. 참여 멤버</h2>
            {{--<ul class="tabs member-tab-menu flex-wrap left">
                <li class="tab active">기본 멤버</li>
                <li class="tab">대기 멤버</li>
            </ul>--}}
            <div class="member-list-wrap scroll-box" style="max-height: 300px">
                <ul class="member-list">
                    <li class="title">
                        <span class="no">No</span>
                        <span class="profile"></span>
                        <span class="nickname">닉네임</span>
                        <span class="name">이름</span>
                        <span class="date">참가 일시</span>
                        <span class="actions"></span>
                    </li>
                @foreach($study['members'] as $key => $val)
                    <li>
                        <span class="no">{{$key+1}}</span>
                        <div class="profile {{ $val['pivot']['rank'] === '0' ? 'crown':'' }}">
                            <div>
                                <img src="{{ !empty($val['profile_url']) ? asset('storage/'.$val['profile_url']):asset('images/default-profile.png') }}" alt="프로필 이미지"/>
                            </div>
                        </div>
                        <span class="nickname">{{$val['nickname']}}</span>
                        <span class="name">{{$val['name']}}</span>
                        <span class="date">{{$val['pivot']['join_datetime']}}</span>
                        <div class="actions-btn">
                            @if( $val['pivot']['rank'] !== '0' && auth()->check() && Auth::user()->id === $study['owner_id'])
                            <button type="button" class="cm-btn exit-btn" onclick="participationStudy({{$val['id']}},'leave')">퇴장</button>
                            @endif
                                {{-- <button class="btn btn-block">차단</button> --}}
                        </div>
                    </li>
                @endforeach
            </table>
            </div>
        </div>
        <div class="write-content detail comments">
            <div class="my-comments-wrap">
                <div class="flex-wrap">
                    <h2>댓글 <span>{{$comments_count}}</span></h2>
                    <p><i class="xi-eye-o"></i> <span>10</span></p>
                </div>
                @if(auth()->check())
                <form action="#" method="POST">
                    <div class="flex-wrap my-comments">
                        <div>
                            @if(Auth::user()-> profile_url)
                            <img src="{{asset('storage/'.Auth::user()-> profile_url)}}" alt="프로필 이미지">
                            @else
                             <img src="{{asset('images/default-profile.png')}}" alt="프로필 이미지">
                            @endif
                        </div>
                        <div>
                            <textarea name="comments"></textarea>
                        </div>
                    </div>
                    <div class="flex-wrap right my-comments-buttons">
                        <button onclick="formSend(this.form, 'POST')" type="button">댓글 등록</button>
                    </div>
                </form>
                 @else
                 <div class="guest-info">
                    <p>댓글을 작성하려면 로그인이 필요해요.</p>
                    <a href="{{route('login')}}" class="cm-btn">로그인하러가기</a>
                </div>
                @endif
            </div>
            <ul class="comments-list">
                @foreach($comments as $key => $val)
                    <li>
                        <div class="comments-title flex-wrap">
                            <div class="comments-info flex-wrap">
                                <img src="{{ !empty($val-> members -> profile_url) ? asset('storage/'.$val-> members -> profile_url):asset('images/default-profile.png') }}" alt="프로필 이미지"/>
                                <span class="name">{{$val -> members -> nickname}}</span>
                                @if($study['owner_id'] === $val -> members ->id)
                                    <span class="cm-label iswriter">작성자 <i class="xi-crown"></i></span>
                                @endif
                                <span class="create-date">{{$val-> created_at}}</span>
                            </div>
                            <div class="comments-buttons">
                                @if(auth()->check() && $val -> status ==='active' && (Auth::user()->id === $val->members->id || Auth::user()->id === $study['owner_id'] || Auth::user()->id === 1 ))
                                    @if(Auth::user()->id === $val->members->id)
                                        <span onclick="editComments(this,{{$val -> id}} )">수정</span>
                                    @endif
                                    <span onclick="formSend(null, 'DELETE', {{$val['id']}})">삭제</span>
                                @endif
                                <span onclick="replyAdd(this, {{$val['id']}})">답글</span>
                            </div>
                        </div>
                        <div class="comments-con">
                            @if($val -> status ==='active')
                                <textarea readonly>{{$val->content}}</textarea>
                            @else
                                <p class="deleted-comments"><i class="xi-trash"></i><span>{{$val -> status === 'd_by_user'?'작성자':($val -> status === 'd_by_admin'?'관리자':'스터디장')}}</span>님이 삭제한 댓글입니다.</p>
                            @endif
                        </div>
                        @if(!empty($val->children))
                            <ul class="comments-in-list">
                            @foreach($val->children as $in_key => $in_val)
                                <li>
                                    <div class="comments-title flex-wrap">
                                        <div class="comments-info flex-wrap">
                                            <img src="{{ !empty($in_val-> members -> profile_url) ? asset('storage/'.$in_val-> members -> profile_url):asset('images/default-profile.png') }}" alt="프로필 이미지"/>
                                            <span class="name">{{$in_val-> members -> nickname}}</span>
                                            @if($study['owner_id'] === $in_val -> members ->id)
                                                <span class="cm-label iswriter">작성자 <i class="xi-crown"></i></span>
                                            @endif
                                            <span class="create-date">{{$val-> updated_at}}</span>
                                        </div>
                                        @if(auth()->check()&& $in_val -> status ==='active' && (Auth::user()->id === $in_val->members->id || Auth::user()->id === $study['owner_id'] || Auth::user()->id === 1 ))
                                        <div class="comments-buttons">
                                            @if(Auth::user()->id === $in_val->members->id)
                                                <span onclick="editComments(this, {{$in_val -> id}}, {{$val -> id}})">수정</span>
                                            @endif
                                            <span onclick="formSend(null, 'DELETE', {{$in_val['id']}})">삭제</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="comments-con">
                                    @if($in_val -> status ==='active')
                                        <textarea readonly>{{$in_val->content}}</textarea>
                                    @else
                                        <p class="deleted-comments"><i class="xi-trash"></i><span>{{$in_val -> status === 'd_by_user'?'작성자가':($in_val -> status === 'd_by_admin'?'관리자가':'스터디장이')}}</span> 님이 삭제한 댓글입니다.</p>
                                    @endif
                                    </div>
                                </li>
                            @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
               {{-- <li>
                    <div class="comments-title flex-wrap">
                        <div class="comments-info flex-wrap">
                            <img src="{{asset('storage/'.Auth::user()-> profile_url)}}" alt="">
                            <span class="name">{{Auth::user()-> nickname}}</span>
                            <span class="create-date">{{Auth::user()-> created_at}}</span>
                        </div>
                        <div class="comments-buttons">
                            <span>수정</span>
                            <span>삭제</span>
                            <span>답글</span>
                        </div>
                    </div>
                    <div class="comments-con">
                        <pre></pre>
                    </div>
                    <ul class="comments-in-list">
                        <li>
                            <div class="my-comments-wrap">
                                <div class="flex-wrap">
                                    <h2>댓글</h2>
                                    <span>{{}}</span>
                                </div>
                                <div class="flex-wrap my-comments">
                                    <div>
                                        <img src="{{asset('storage/'.Auth::user()-> profile_url)}}" alt="">
                                    </div>
                                    <div>
                                        <textarea name="in-comments"></textarea>
                                    </div>
                                </div>
                                <div class="flex-wrap right my-comments-buttons">
                                    <button type="button">답글 등록</button>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="comments-title flex-wrap">
                                <div class="comments-info flex-wrap">
                                    <img src="{{asset('storage/'.Auth::user()-> profile_url)}}" alt="">
                                    <span class="name">{{Auth::user()-> nickname}}</span>
                                    <span class="create-date">{{Auth::user()-> created_at}}</span>
                                </div>
                                <div class="comments-buttons">
                                    <span>수정</span>
                                    <span>삭제</span>
                                </div>
                            </div>
                            <div class="comments-con">
                                <pre>답글 이야</pre>
                            </div>
                        </li>
                    </ul>
                </li> --}}
            </ul> 
        </div>
    </div>
</section>
<script type="text/javascript">
    const oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "ir1",
        sSkinURI: "{{ asset('plugin/se2/SmartEditor2Skin.html') }}",
        fCreator: "createSEditor2",
        fOnAppLoad: function(){
            let editor = oEditors.getById["ir1"];
            editor.exec("DISABLE_WYSIWYG");
            editor.exec("DISABLE_ALL_UI");
        }
    });

        // 참가/퇴장
    async function participationStudy(id, url=''){
        
        if(url === 'exit' && !(await APP_FUNC.commonFunc.confirmOpen(`정말로 스터디에서 퇴장하시겠습니까? 다시 참여하려면 스터디장의 승인이 필요합니다.`))){
            return;
        }

        if(url === 'leave' && !(await APP_FUNC.commonFunc.confirmOpen(`정말로 스터디에서 퇴장시키시겠습니까?`))){
            return;
        }

        let urlPath = url === ''? '':url+"/";
        fetch(`/study/participation/${urlPath}${id}`,{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
            },
            body: url === 'leave'?JSON.stringify({'member_id':id,'study_id':{{$study['id']}}}):{}
                //: JSON.stringify(dataToSend)
        })
        .then(res => {
            if(!res.ok){
                throw new Error("서버 에러 상태코드: "+res.status);
            }
            return res.json();
        })
        .then(data => {
            APP_FUNC.commonFunc.modalOpen('alert-btn',data.msg,'btn-include');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        })
        .catch(err => {
            APP_FUNC.commonFunc.modalResponseHidden(err.message, 'fail');
        });
    }




    function editComments(thisO, commentId, parentId=null){
        const textareaEl = $(thisO).parent().parent().parent().find("textarea");
        if($(textareaEl).prop("readonly")){
            $(textareaEl).prop("readonly", false);
        }else{
            $(textareaEl).prop("readonly", true);
            formSend($(textareaEl).val(), 'PUT', commentId, parentId);
        }
    }

    function replyAdd(thisO, commentsId){
        const parentEl = $(thisO).parent().parent().parent(); 
        const isFirstLi = $(parentEl).find("ul").length === 0 ? true:false;
        const liLayout = `<li>
                                <div class="my-comments-wrap">
                                    <div class="flex-wrap">
                                        <h2>답글</h2>
                                    </div>
                                    <div class="flex-wrap my-comments">
                                        <div>
                                            <img src="{{auth()->check()? asset('storage/'.Auth::user()-> profile_url):''}}" alt="">
                                        </div>
                                        <div>
                                            <textarea name="in-comments"></textarea>
                                        </div>
                                    </div>
                                    <div class="flex-wrap right my-comments-buttons">
                                        <button type="button" onclick="formSend(this, 'POST','', ${commentsId})">답글 등록</button>
                                    </div>
                                </div>
                            </li>`;
        const ulEl = $(`<ul class='comments-in-list'>
                            ${liLayout}
                        </ul>`);
        if(isFirstLi){
            $(parentEl).append(ulEl);
        }else{
            $(parentEl).find('ul').append(liLayout);
        }
    }

   async function formSend(f = null, methodType, commentId="", parentId="") {
        const url = methodType === 'PUT'||'DELETE' ? '/'+commentId:'';
        let sendData = [];
        if(methodType === 'DELETE' && !(await APP_FUNC.commonFunc.confirmOpen())){
            return;
        }
        // if (!f.checkValidity()) {
        //     alert("필수 값을 넣지 않았습니다. 입력값을 다시 확인해주세요!");
        //     return;
        // }

        let formData = null;
        // $(".loading-sec").addClass('active');
        if(methodType === 'PUT'){
            sendData = {
                "comments":f,
                "parent_id": parentId,
            }
        }else if(methodType === 'DELETE'){
           let status = '';

           @if(auth()->check())
                @if(auth()->id() === $study['owner_id'])
                    status="d_by_leader";
                @elseif(auth()->id() === 1)
                    status="d_by_admin";
                @else
                    status="d_by_user";
                @endif
           @endif
            sendData = {
                "status": status,
            }
        }
        else if(parentId === ''){ // 일반 댓글
            formData =  new FormData(f);
            formData.append("study_id", {{$study['id']}});
            if(parentId !== ''){
                formData.append("parent_id", parentId);
            }
            sendData = Object.fromEntries(formData.entries());
        }
        else{ // 대댓글일때
            console.log($(f).parent().parent().find("textarea").val());
            sendData = {
                "study_id": {{$study['id']}},
                "comments": $(f).parent().parent().find("textarea").val(),
                "parent_id": parentId,
            }
        }
        
        
        fetch('/comment'+ url,{
            method: methodType,
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
            // alert("성공:" + data.msg);
            if(data.state === 'success'){
                window.location.reload();
            }else{
                APP_FUNC.commonFunc.modalOpen('alert-btn',data.msg, 'btn-include');
            }
        })
        .catch(err => {
            console.log("실패:", err);
            APP_FUNC.commonFunc.modalOpen('alert-btn','실패', 'btn-include');
        });
    }


    function noticeSend(f=null){
        console.log('f',f);
        if(!!f){
            const formEl = $(`form[name=${f}]`);
            const formData = new FormData(formEl.get(0));
            formData.append('study_id',{{$study['id']}});
            APP_FUNC.commonFunc.commonSendForm(formData, 'POST', '/notice', '공지가 저장');
        }

        else if($("#notice-title").val() !== '' && $("#notice-content").val() !== ''){
            $("#notice-create-btn").prop("disabled", false);
        }else{
            $("#notice-create-btn").prop("disabled", true);
        }
    }
</script>

@endsection
