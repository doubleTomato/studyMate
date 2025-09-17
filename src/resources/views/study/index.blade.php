{{-- 메인화면 --}}
@extends('layouts.app')
@section('content')
@php
    //$today = (new DateTime()) ->setTime(0, 0);
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
        <ul id="study-list" class="list-wrap">
            @include('study._list', ['study' => $study])
        </ul>
    </div>
    <div id="paginationSec" class="pagination-sec">
        {{ $study -> links()}}
    </div>
</section>
@endsection
<script type="text/javascript">
document.addEventListener('click', async function(e){
    const a = e.target.closest('.pagination a');
    if(!a) return;
    $(".loading-sec").show();
    e.preventDefault();
    const url = a.href; // 절대경로 사용
    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    const html = await res.text();
    document.getElementById('study-list').innerHTML = html;
    $(".loading-sec").hide();
});

</script>