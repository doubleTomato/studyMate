{{-- 메인화면 --}}
@extends('layouts.app')
@section('content')
{{-- {{ dd($studies) }} --}}
@php
    $today = new DateTime();
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
        @foreach($studies as $key => $val)
            @php
                $deadlineDate = DateTime::createFromFormat('Y-m-d',  $val['deadline']);
                $d_day = $deadlineDate -> diff($today)
            @endphp
            <li>
                <div class="flex-wrap">
                    <p class="list-tit">
                        {{$val['title']}}
                    </p>
                    <div class="list-deadline">
                        <span class="{{ $d_day -> invert === 0 ? 'cm-label deadline':'' }}">{{ $d_day -> invert === 0 ? '마감':$d_day -> format('D%R%a') }}</span> <span class="helper-text">({{ $val['deadline'] }})</span>
                    </div>
                </div>
                
                <div>
                    <p><i class="xi-marker-circle"></i></p>
                    {{$val['region_id']}}
                </div>
                <div>
                </div>
                
                <div>
                    <p><i class="xi-calendar"></i></p>
                    {{ $val['start_date'] }} ~ {{ $val['end_date'] }}
                </div>
                <div>
                    <p><i class="xi-community"></i></p>
                    <div class="progress-bar">
                        <div class="progress" style="width: {{-- (100 / $data['study']['max_members']) * count($data['participants']) --}}%"></div>
                        <div>
                            <span>{{-- count($val['participants']) --}}</span>
                            <span>/</span>
                            <span>
                                {{ $val['max_members'] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    {{$val['views']}}
                </div>
            </li>
        @endforeach
        </ul>
    </div>
</section>
@endsection