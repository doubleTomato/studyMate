@php
    use Carbon\Carbon;
    $today = new DateTime();
    $deadlineDate = DateTime::createFromFormat('Y-m-d',  $data['study']['deadline']);
    $isClosed = $today > $deadlineDate || count($data['participants']) === $data['study']['max_members'];

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

@endphp
{{-- 스터디 모집 글 상세 --}}
@extends('layouts.app')
@section('content')
{{-- dd($data['study']) --}}
<section class="detail-sec">
    <div class="flex-wrap title-wrap">
        <h1><span class="{{ $d_day_class }}"> {{ $d_day_val }}</span> {{ $data['study']['title'] }}</h1>
        @if(!$isClosed)
        <button type="button" class="icon-btn plus-user cta-btn">
            <i class="xi-user-plus"></i>
            <span>참여하기</span>
        </button>
        @endif
    </div>
    <div class="flex-wrap header-wrap">
        <div class="header-con">
            <p><i class="xi-crown"></i><span class="leader">{{ $data['leader']['nickname'] }}</span><span class="helper-text">{{  Carbon::parse($data['study']['updated_at']) ->format('Y.m.d H:i')  }}</span></p>
        </div>
        <div class="button-con">
            <a class="cm-btn" href="{{ route('study.index') }}">목록으로</a>
            @if(!$isClosed) 
                <a class="cm-btn" href="{{ route('study.edit', $data['study']['id']) }}">수정하기</a>
            @endif
        </div>
    </div>
    <div class="flex-wrap right delete-btn-wrap">
        <form method="POST" action="#">
            @method('DELETE')
            @csrf
            @if(!$isClosed)
                <button type="button" onclick="APP_FUNC.inputFunc.sendData(this.form, 'DELETE', '/{{$data['study']['id']}}')" class="cm-btn delete-btn">삭제하기</button>
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
                        {{-- $data['category'][$data['study']['category_id']] --}}
                        {{ $data['category'][$data['study']['category_id']]['title'] }}
                    </div>
                </li>
                <li>
                    <div class="label">모집 인원</div>
                    <div class="value">
                        <div class="participants-count">
                            <div class="progress-bar">
                                <div class="progress" style="width: {{ (100 / $data['study']['max_members']) * count($data['participants']) }}%"></div>
                                <div>
                                    <span>{{ count($data['participants']) }}</span>
                                    <span>/</span>
                                    <span>
                                        {{ $data['study']['max_members'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="participants-list">
                            <div>
                                <a class="cm-btn" title="참여멤버전체보기" href="#member-lists">참여멤버전체보기</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="label">모집 마감일<i class="xi-calendar"></i></div>
                    <div class="value">
                        {{ $data['study']['deadline'] }}
                    </div>
                </li>
                <li>
                    <div class="label">스터디 기간<i class="xi-calendar"></i></div>
                    <div class="value">
                        <div class="datetime-wrap">
                            @if(!empty($data['study']['end_date']))
                                <span>{{ $data['study']['start_date'] }}</span>
                                <span>~</span>
                                <span>{{$data['study']['end_date']}}</span>
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
                            @if($data['study']['is_offline'] === 0)
                                {{ $data['region'][$data['study']['region_id']]['name'] }}
                            @else
                                온라인 진행
                            @endif
                        </div>
                    </div>
                </li>
                <li>
                    <div class="label">상세 주소</div>
                    <div class="value">{{ $data['study']['location'] }}</div>
                </li>
            </ul>
        </div>
        <div class="write-content detail">
            <h2>2. 세부 내용</h2>
            <textarea style="width: 100%" name="ir1" id="ir1" rows="10" cols="100" readonly>
                {{ $data['study']['description'] }}
            </textarea>
        </div>
        <div id="member-lists" class="write-content detail">
            <h2>3. 참여 멤버</h2>
            
            <ul class="tabs member-tab-menu flex-wrap left">
                <li class="tab active">기본 멤버</li>
                <li class="tab">대기 멤버</li>
            </ul>
            <div class="member-list-wrap">
                <ul class="member-list">
                    <li class="title">
                        <span class="no">No</span>
                        <span class="profile"></span>
                        <span class="name">이름</span>
                        <span class="nickname">닉네임</span>
                        <span class="date">참가일</span>
                        <span class="actions"></span>
                    </li>
                @foreach($data['participants'] as $key => $val)
                    <li>
                        <span class="no">{{$key+1}}</span>
                        <div class="profile {{ $val['rank'] === '0' ? 'crown':'' }}">
                            <img src="{{ !empty($val['profile_url']) ? asset($participants['profile_url']):asset("images/default-profile.png") }}" alt="프로필 이미지"/>
                        </div>
                        <span class="name">{{$val['name']}}</span>
                        <span class="nickname">{{$val['nickname']}}</span>
                        <span class="date">2025-09-18</span>
                        <div class="actions-btn">
                            <button type="button" class="cm-btn exit-btn">퇴장</button>
                                {{-- <button class="btn btn-block">차단</button> --}}
                        </div>
                    </li>
                @endforeach
            </table>
            </div>
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

</script>

@endsection
