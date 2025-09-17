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
                            <input type="number" name="recruited-num" required>
                        </td>
                    </tr>
                    <tr>
                        <th>모집 마감일<i class="xi-calendar"/></th>
                        <td>
                            <input type="text" class="datepicker"  id="deadLine" name="deadline-date" required>
                        </td>
                        <th>스터디 기간<i class="xi-calendar"/></th>
                        <td>
                            <div class="datetime-wrap">
                                <input type="text" class="datepicker" id="start-date" name="start-date" required>
                                <span>~</span>
                                <input type="text" class="datepicker"  id="end-date" name="end-date">
                            </div>
                            <div class="datetime-duration-disable">
                                <input onclick="APP_FUNC.inputFunc.checkDisabled(this, ['end-date'])" id="durationdisable" type="checkbox" name="durationdisable"/>
                                <label for="durationdisable">기간 제한 없음</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>지역</th>
                        <td>
                            <div class="region-wrap">
                                <div>
                                    <input onclick="APP_FUNC.inputFunc.checkDisabled(this, ['region-sel','location'])" id="is-offline" type="checkbox" name="is-offline" value="1"/>
                                    <label for="is-offline">온라인 진행</label>
                                </div>
                                <select class="select2-basic" id="region-sel" name="region">
                                    <option value="">선택해주세요.</option>
                                </select>
                            </div>
                        </td>
                        <th>상세 주소<span class="helper-text">(선택)</span></th>
                        <td><input type="text" name="location" id="location"></td>
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
                            <input type="text" name="titlename" required>
                        </td>
                    </tr>
                </table>
                <textarea required style="width: 100%" name="ir1" id="ir1" rows="10" cols="100">에디터에 기본으로 삽입할 글(수정 모드)이 없다면 이 value 값을 지정하지 않으시면 됩니다.</textarea>
            </div>
        </div>
        <div class="button-con">
            <button type="button">취소</button>
            <button class="cta-btn" type="button" onclick="APP_FUNC.inputFunc.sendData(this.form, 'POST')">등록하기</button>
            {{-- <button type="submit">등록하기</button> --}}
        </div>
    </form>
</section>

@section('loading-msg')

@endsection
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

    }
    
</script>
@endsection