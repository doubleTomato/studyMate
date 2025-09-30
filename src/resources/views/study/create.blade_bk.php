@if(!auth()->check())
    <script>
        alert("로그인이 필요한 페이지 입니다.");
        window.location.href = `/login`;
    </script>
@endif
{{-- 스터디 모집 글 생성 --}}
@extends('layouts.app')
@section('content')
<section class="write-sec">
    <form method="POST" action="/study/write">
        @csrf
        <div class="content-tit">
            <div class="write-content information">
                <h1>1. 기본 정보</h1>
                <table>
                    <colgroup>
                        <col width="20%" style="width: 15%"/>
                        <col width="80%" style="width: 35%"/>
                        <col width="20%" style="width: 15%"/>
                        <col width="80%" style="width: 35%"/>
                    </colgroup>
                    <thead></thead>
                    <tbody>
                    <tr>
                        <th>카테고리</th>
                        <td>
                            <select class="select2-basic" id="category-sel" name="category" required>
                                <option value="">선택해주세요</option>
                            </select>
                        </td>
                        <th>모집 인원</th>
                        <td>
                            <div class="recruited-num-wrap flex-wrap">
                                <input type="number" name="recruited-num" min="0" value="0" required placeholder="모집 인원을 입력해주세요.">
                                <div class="flex-wrap">
                                    <button onclick="APP_FUNC.commonFunc.addCount(5)" type="button">+5</button>
                                    <button onclick="APP_FUNC.commonFunc.addCount(10)" type="button">+10</button>
                                    <button onclick="APP_FUNC.commonFunc.addCount(15)" type="button">+15</button>
                                    <button onclick="APP_FUNC.commonFunc.addCount(0)" type="button"><i class="xi-refresh"></i></button>
                                </div>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <th>모집 마감일<i class="xi-calendar"/></th>
                        <td>
                            <input type="text" class="datepicker" placeholder="yyyy-mm-dd"  id="deadLine" name="deadline-date" required autocomplete="off">
                        </td>
                        <th>스터디 기간<i class="xi-calendar"/></th>
                        <td>
                            <div class="datetime-wrap">
                                <input type="text" class="datepicker" placeholder="yyyy-mm-dd" id="start-date" name="start-date" required autocomplete="off">
                                <span>~</span>
                                <input type="text" class="datepicker" placeholder="yyyy-mm-dd"  id="end-date" name="end-date" autocomplete="off">
                            </div>
                            <div class="datetime-duration-disable">
                                <input onclick="APP_FUNC.commonFunc.checkDisabled(this, ['end-date'])" id="durationdisable" type="checkbox" name="durationdisable"/>
                                <label for="durationdisable">기간 제한 없음</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>지역</th>
                        <td>
                            <div class="region-wrap">
                                <div>
                                    <input onclick="APP_FUNC.commonFunc.checkDisabled(this, ['region-sel','location'])" id="is-offline" type="checkbox" name="is-offline" value="1"/>
                                    <label for="is-offline">온라인 진행</label>
                                </div>
                                <select class="select2-basic" id="region-sel" name="region">
                                    <option value="">선택해주세요.</option>
                                </select>
                            </div>
                        </td>
                        <th>상세 주소<span class="helper-text">(선택)</span></th>
                        <td><input type="text" name="location" id="location" placeholder="예: 서울시 강남구 …"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="write-content detail">
                <h1>2. 세부 내용</h1>
                <table>
                    <tr>
                        <th>제목</th>
                        <td>
                            <input type="text" name="titlename" required placeholder="제목을 입력해주세요.">
                        </td>
                    </tr>
                </table>
                <textarea required style="width: 100%" name="ir1" id="ir1" rows="10" cols="100">스터디의 상세 설명을 입력해주세요.</textarea>
            </div>
        </div>
        <div class="button-con">
            <button type="button">취소</button>
            <button class="cta-btn" type="button" onclick="APP_FUNC.commonFunc.sendData(this.form, 'POST')">등록하기</button>
            {{-- <button type="submit">등록하기</button> --}}
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

    // oEditors.getById["ir1"].exec("PASTE_HTML",  ["스터디의 상세 설명을 입력해주세요."]);

    window.onload = function(){
        APP_FUNC.commonFunc.categoryReturn('category-sel');
        APP_FUNC.commonFunc.regionReturn('region-sel');
        APP_FUNC.commonFunc.dateDisabled(); // datetime 초기화
    }
    
</script>
@endsection