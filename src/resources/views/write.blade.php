{{-- 스터디 모집 글 생성 --}}
@extends('layouts.app')
@section('content')
<script type="text/javascript" src="{{ asset('plugin/se2/js/service/HuskyEZCreator.js') }}" charset="utf-8"></script>
<section class="write-sec">
    <form method="POST" action="/create">
        @csrf
        <div class="content-tit">
            <div class="write-content information">
                <h1>1. 기본 정보</h1>
                <table>
                    <tr>
                        <th>카테고리</th>
                        <td>
                            <select id="category-sel" name="category">
                                <option>1</option>
                            </select>
                        </td>
                        <th>모집 인원</th>
                        <td>
                            <input type="number" name="recruited-num">
                        </td>
                    </tr>
                    <tr>
                        <th>모집 마감일</th>
                        <td>
                            <input type="datetime" class="datepicker"  id="deadLine" name="deadline-date">
                        </td>
                        <th>모집 기간</th>
                        <td>
                            <div class="datetime-wrap">
                                <input type="datetime" class="datepicker" id="start-date" name="start-date">
                                <span>~</span>
                                <input type="datetime" class="datepicker"  id="end-date" name="end-date">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="isOnline">온라인 가능 여부</label></th>
                        <td>
                            <input id="isOnline" type="checkbox" name="isOnline"/>
                        </td>
                        <th>지역</th>
                        <td>
                            <select id="region-sel" name="location">
                                <option>1</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="write-content detail">
                <h1>2. 세부 내용</h1>
                <table>
                    <tr>
                        <th>제목</th>
                        <td>
                            <input type="text" name="titlename">
                        </td>
                    </tr>
                </table>
                <textarea style="width: 100%" name="ir1" id="ir1" rows="10" cols="100">에디터에 기본으로 삽입할 글(수정 모드)이 없다면 이 value 값을 지정하지 않으시면 됩니다.</textarea>
            </div>
        </div>
        <div class="button-con">
            <button type="button">등록하기</button>
        </div>
    </form>
</section>
<script type="text/javascript">
    const oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "ir1",
        sSkinURI: "{{ asset('plugin/se2/SmartEditor2Skin.html') }}",
        fCreator: "createSEditor2"
    });

    

    window.onload = function(){
        APP_FUNC.inputFunc.categoryReturn('category-sel');
        APP_FUNC.inputFunc.regionReturn('region-sel');

        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            showAnim: 'slideDown'
        });

    }
</script>
@endsection