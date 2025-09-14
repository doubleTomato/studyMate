{{-- 메인화면 --}}
@extends('layouts.app')
@section('content')
{{-- {{ dd($studies) }} --}}
@php
    $today = new DateTime();
    // dd($participants);
@endphp
<section class="list-sec">
    {{-- <h1>스터디 모집글</h1> --}}
    <div class="content-head flex-wrap">
        <ul class="filter-list">
            <li><input type="text" name="search"><i class="xi-search"></i></li>
            <li><button class="icon-button"><i class="xi-location-arrow"></i>지역 선택</button></li>
            <li><button class="icon-button"><i class="xi-tags"></i>카테고리 선택</button></li>
            <li><button class="icon-button"><i class="xi-repeat"></i>진행중인것만</button></li>
        </ul>
        <div>
            <select>
                <option>인기순</option>
                <option>최신순</option>
                <option>마감임박순</option>
            </select>
        </div>
    </div>
    <div class="content">
        <ul class="list-wrap">
        @foreach($studyJoin as $key => $val)
            @php
                $deadlineDate = DateTime::createFromFormat('Y-m-d',  $val['deadline']);
                $d_day = $deadlineDate -> diff($today)
            @endphp
            <li onclick="window.location.href='/detail/{{$val['id']}}'">
                <div class="flex-wrap">
                    <p class="list-tit" title="{{$val['title']}}">
                        {{$val['title']}}
                    </p>
                    <div class="list-deadline">
                        <span class="{{ $d_day -> invert === 0 ? 'cm-label deadline':'d-day' }}">{{ $d_day -> invert === 0 ? '마감':$d_day -> format('D%R%a') }}</span>
                        <span class="helper-text">({{ $val['deadline'] }})</span>
                    </div>
                </div>
                
                <div>
                    <p><i class="xi-marker-circle"></i></p>
                    @if($val['is_offline'] === 0 )
                        <p>{{$val['regions_name']}}</p>
                        <p class="helper-text">{{ !empty($val['location']) ? '('.$val['location'].')' : ''}}</p>
                    @else
                        <p>Online</p>
                    @endif
                </div>
                <div>
                    <p><i class="xi-calendar"></i></p>
                    {{ $val['start_date'] }} ~ {{ !empty($val['end_date']) ? $val['end_date']:'기한없음' }}
                </div>
                <div class="participants-wrap">
                    <div class="participants-count">
                        <p><i class="xi-community"></i></p>
                        <div class="progress-bar">
                            <div class="progress" style="width: {{ (100 / $val['max_members']) * count($participants[$val['id']]) }}%"></div>
                            <div>
                                <span>{{ count($participants[$val['id']]) }}</span>
                                <span>/</span>
                                <span>
                                    {{ $val['max_members'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex-wrap">
                        <ul class="participants-profile">
                            <li><i class="xi-user"></i></li>
                            @foreach($participants[$val['id']] as $in_key => $in_val)
                            <li>
                                @if($in_key > 1)
                                    <span class="xi-plus-circle-o"></span>
                                    @break
                                @else
                                    <span class="{{ $in_val['members_name'] }}"><i class="{{$in_val['study_member_rank'] === 0 ?? "xi-crown"}}"></i></span>
                                @endif
                                </li>
                            @endforeach
                        </ul>
                        <p>
                            <span><i class="xi-eye-o"></i></span>
                            <span>{{$val['views']}}</span></p>
                    </div>
                </div>
            </li>
        @endforeach
        </ul>
    </div>
    <ul class="pagination-sec">
        <li>1</li>
    </ul>
</section>
@endsection