@php
    use Carbon\Carbon;
    $today = new DateTime();
    $deadlineDate = DateTime::createFromFormat('Y-m-d',  $data['study']['deadline']);
    $isClosed = $today < $deadlineDate || count($data['participants']) === $data['study']['max_members'];
@endphp
{{-- 스터디 모집 글 생성 --}}
@extends('layouts.app')
@section('content')
{{-- dd($data['study']) --}}
<section class="detail-sec">
    <div class="flex-wrap title-wrap">
        <h1><span class="cm-label {{ $isClosed ? 'deadline':'in-progress'  }}"> {{ 'deadline' ? "마감":"모집중" }}</span> {{ $data['study']['title'] }}</h1>
        @if(!$isClosed)
        <button type="button" class="icon-button plus-user cta-button">
            <i class="xi-user-plus"></i>
            <span>참여하기</span>
        </button>
        @endif
    </div>
    <div class="flex-wrap">
        <div class="header-con">
            <p><i class="xi-crown"></i><span class="leader">{{ $data['leader']['nickname'] }}</span><span class="helper-text">{{  Carbon::parse($data['study']['updated_at']) ->format('Y.m.d H:i')  }}</span></p>
        </div>
        <div class="button-con">
            <button onclick="window.location.href='/study'" type="button">목록으로</button>
            @if(!$isClosed) 
                <button type="button" onclick="sendData(this.form)">수정하기</button>
            @endif
        </div>
    </div>
    <hr>
    <div class="content-tit">
        <div class="detail-content information">
            <h2>1. 기본 정보</h2>
            <table>
                <colgroup>
                    <col width="20%" style="width: 15%"/>
                    <col width="80%" style="width: 35%"/>
                    <col width="20%" style="width: 15%"/>
                    <col width="80%" style="width: 35%"/>
                </colgroup>
                <tbody>
                <tr>
                    <th>카테고리</th>
                    <td>
                        {{-- $data['category'][$data['study']['category_id']] --}}
                        {{ $data['category'][$data['study']['category_id']]['title'] }}
                    </td>
                    <th>모집 인원</th>
                    <td>
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
                            <div class="flex-wrap">
                                <div class="flex-wrap list-title">
                                    <h3>현재 참여자 목록</h3>
                                    {{-- ###로그인 한 사용자가 현재 스터디에 참여하지 않았다면 출력 --}}
                                    
                                </div>
                                <button type="button" title="상세보기" onclick="APP_FUNC.inputFunc.foldToggle(this)" type="button"><i class="xi-caret-down"></i></button>
                            </div>
                            <ul class="fold-wrap fold">
                                @foreach($data['participants'] as $key => $val)
                                    <li>
                                        <span><i class="{{ $val['rank'] === '1' ? "xi-crown" : "xi-user" }}"></i></span>
                                        &nbsp;
                                        <span>{{ $val['nickname'] }}</span>
                                    </li>
                                @endforeach 
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>모집 마감일<i class="xi-calendar"/></th>
                    <td>
                        {{ $data['study']['deadline'] }}
                    </td>
                    <th>스터디 기간<i class="xi-calendar"/></th>
                    <td>
                        <div class="datetime-wrap">
                            @if(!empty($data['study']['end_date']))
                                <span>{{ $data['study']['start_date'] }}</span>
                                <span>~</span>
                                <span>{{$data['study']['end_date']}}</span>
                            @else
                                (<label for="durationdisable">기간 제한 없음</label>)
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>지역</th>
                    <td>
                        <div class="region-wrap">
                            @if($data['study']['is_offline'] === 0)
                                {{ $data['region'][$data['study']['region_id']]['name'] }}
                            @else
                                온라인 진행
                            @endif
                        </div>
                    </td>
                    <th>상세 주소</th>
                    <td>{{ $data['study']['location'] }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="write-content detail">
            <h2>2. 세부 내용</h2>
            <pre>{{$data['study']['description']}}</pre>
        </div>
    </div>
</section>
@endsection