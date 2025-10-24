{{-- 메인화면 --}}
@extends('layouts.app')
@section('content')
<section class="list-sec">
    <input type="hidden" name="pagination" value="">
    {{-- <h1>스터디 모집글</h1> --}}
    <div class="content-head flex-wrap">
        <ul class="filter-list">
            <li class="flex-wrap left search-wrap">
                <input type="text" name="search" onkeyup="enterkey()">
                <button type="button" onclick="APP_FUNC.commonFunc.filterChange()"><i class="xi-search"></i></button>
            </li>
            <li>
                <select class="select2-basic" name="region" onchange="APP_FUNC.commonFunc.filterChange()">
                    <option value="">지역 선택</option>
                    @foreach($region as $key => $val)
                        <option value="{{$val['id']}}">{{$val['name']}}</option>
                    @endforeach
                </select>
            </li>
            <li>
                <select class="select2-basic" name="category" onchange="APP_FUNC.commonFunc.filterChange()">
                    <option value="">카테고리 선택</option>
                    @foreach($category as $key => $val)
                        <option value="{{$val['id']}}">{{$val['title']}}</option>
                    @endforeach
                </select>
            </li>
            <li>
                <button id="active-btn" onclick="APP_FUNC.commonFunc.filterChange('',true)" class="icon-btn">
                    <i class="xi-repeat"></i>진행중인것만
                </button>
                <input type="hidden" name="active" value="false"/>
            </li>
            <li>
                <button type="button" onclick="APP_FUNC.commonFunc.filterChange('r')">
                    <i class="xi-refresh"></i>
                </button>
            </li>
        </ul>
        <div>
            <select  class="select2-basic" name="sort" onchange="APP_FUNC.commonFunc.filterChange()">
                <option value="popular">인기순</option>
                <option value="">최신순</option>
                <option value="oldest">오래된순</option>
                <option value="deadline">마감임박순</option>
            </select>
        </div>
    </div>
    <div class="content">
        <ul id="study-list" class="list-wrap">
            @include('common._list', ['study' => $study])
        </ul>
    </div>
    <div id="paginationSec" class="pagination-sec">
        {{ $study -> links()}}
    </div>
</section>
@endsection
<script type="text/javascript">
// 페이징 누를 시
document.addEventListener('click', async function(e){
    const aEl = e.target.closest('.pagination a');
    APP_FUNC.commonFunc.paginationChange(aEl);
});

function enterkey() {
	if (window.event.keyCode == 13) {
    	// 엔터키가 눌렸을 때
        APP_FUNC.commonFunc.filterChange();
    }
}

</script>