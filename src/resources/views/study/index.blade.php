{{-- 메인화면 --}}
@extends('layouts.app')
@section('content')
<section class="list-sec">
    <input type="hidden" name="pagination" value="">
    {{-- <h1>스터디 모집글</h1> --}}
    <div class="content-head flex-wrap">
        <ul class="filter-list">
            <li class="flex-wrap left search-wrap">
                <input type="text" name="search">
                <button type="button" onclick="filterChange()"><i class="xi-search"></i></button>
            </li>
            <li>
                <select class="select2-basic" name="region" onchange="filterChange()">
                    <option value="">지역 선택</option>
                    @foreach($region as $key => $val)
                        <option value="{{$val['id']}}">{{$val['name']}}</option>
                    @endforeach
                </select>
            </li>
            <li>
                <select class="select2-basic" name="category" onchange="filterChange()">
                    <option value="">카테고리 선택</option>
                    @foreach($category as $key => $val)
                        <option value="{{$val['id']}}">{{$val['title']}}</option>
                    @endforeach
                </select>
            </li>
            <li>
                <button id="active-btn" onclick="filterChange('',true)" class="icon-btn">
                    <i class="xi-repeat"></i>진행중인것만
                </button>
                <input type="hidden" name="active" value="false"/>
            </li>
            <li>
                <button type="button" onclick="filterChange('r')">
                    <i class="xi-refresh"></i>
                </button>
            </li>
        </ul>
        <div>
            <select  class="select2-basic" name="sort" onchange="filterChange()">
                <option value="popular">인기순</option>
                <option value="">최신순</option>
                <option value="oldest">오래된순</option>
                <option value="deadline">마감임박순</option>
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
// 페이징 누를 시
document.addEventListener('click', async function(e){
    const a = e.target.closest('.pagination a');
    if(!a) return;
    $(".loading-sec").addClass("active");
    e.preventDefault();
    const url = a.href;
    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    const html = await res.text();
    document.getElementById('study-list').innerHTML = html;
    const pageUrl = new URL(a.href);
    const page = pageUrl.searchParams.get('page'); 
    $("input[name='pagination']").val(page);
    $(".loading-sec").removeClass('active');
});

// filter change
async function filterChange(isReset = '', isActive = false){
    let activeVal = '';
    if(isReset === 'r'){
        $("select[name='category']").val('')
        $("select[name='region']").val('');
        $("input[name='search']").val('');
        $("select[name='sort']").val('');
        $("input[name='pagination']").val(1);
        $("input[name='active']").val('false');
        $("#active-btn").removeClass("active");
    }

    let filter1 = isReset !== 'r' ? $("select[name='category']").val() : '';
    let filter2 = isReset !== 'r' ? $("select[name='region']").val() : '';
    let filter3 = isReset !== 'r' ? $("input[name='search']").val() : '';
    let filter4 = isReset !== 'r' ? $("select[name='sort']").val() : '';
    let filter5 = isReset !== 'r' ? $("input[name='pagination']").val() : 1;
    let filter6 = isReset !== 'r' ? $("input[name='active']").val() : '';


    APP_FUNC.commonFunc.modalOpen('alert','필터 적용');


    if(isReset == '' && isActive){
        if($("input[name='active']").val() === 'true'){
            filter6 = 'false';
            $("input[name='active']").val('false');
            $("#active-btn").removeClass("active");
        } else{
            filter6 = 'true';
            $("input[name='active']").val('true');
            $("#active-btn").addClass("active");
        }
    }
    
    const filters = {
            category: filter1,
            region: filter2,
            search: filter3,
            sort: filter4,
            pagination: filter5,
            active: filter6,
        }

     // Ajax 요청
        const res = await fetch('/studies/list', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify(filters)
        });

        const html = await res.text();
        document.getElementById('study-list').innerHTML = html;

        // 페이지 번호 input 초기화
        $("input[name='pagination']").val(filters.pagination);
        APP_FUNC.commonFunc.modalHide('alert');
}


</script>