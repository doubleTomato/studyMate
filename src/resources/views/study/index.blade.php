{{-- 메인화면 --}}
@extends('layouts.app')
@section('content')
{{-- {{ dd($studies) }} --}}

<section class="list-sec">
    <h1>스터디 모집글</h1>
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
            <li>
                <div class="list-deadline">
                    D- {{$val['deadline']}}
                </div>
                <div class="list-tit">
                    {{$val['title']}}
                </div>
                <div>
                    {{$val['owner_id']}}
                </div>
                <div>
                </div>
                
                <div>
                    <p>스터디 기간</p>
                    {{ $val['start_date'] }} ~ {{ $val['end_date'] }}
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