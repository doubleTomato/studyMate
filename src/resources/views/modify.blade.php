{{-- 스터디 모집 글 생성 --}}
@extends('layouts.app')
@section('content')
{{-- dd($data['study']) --}}
<script type="text/javascript" src="{{ asset('plugin/se2/js/service/HuskyEZCreator.js') }}" charset="utf-8"></script>
<section class="detail-sec">
    <div class="button-con">
        <button type="button">목록으로</button>
        <button type="button" onclick="sendData(this.form)">수정하기</button>
        {{-- <button type="submit">등록하기</button> --}}
    </div>
    <hr>
    <div class="content-tit">
        <div class="modify-content information">
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
                        <select id="category-sel" name="category">
                            @foreach($data['category'] as $key => $val)
                                <option value="{{ $key }}" {{ $data['study']['category_id'] === $val['title'] ?? "selected" }} title="{{ $val['description'] }}">{{ $val['title'] }}</option>
                            @endforeach
                        </select>
                    </td>
                    <th>모집 인원</th>
                    <td>
                        <input type="number" name="recruited-num">
                    </td>
                </tr>
                <tr>
                    <th>모집 마감일<i class="xi-calendar"/></th>
                    <td>
                        <input type="datetime" class="datepicker"  id="deadLine" name="deadline-date">
                    </td>
                    <th>모집 기간<i class="xi-calendar"/></th>
                    <td>
                        <div class="datetime-wrap">
                            <input type="datetime" class="datepicker" id="start-date" name="start-date">
                            <span>~</span>
                            <input type="datetime" class="datepicker"  id="end-date" name="end-date">
                        </div>
                        <div class="datetime-duration-disable">
                            <input id="durationdisable" type="checkbox" name="durationdisable"/>
                            <label for="durationdisable">기간 제한 없음</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>지역</th>
                    <td>
                        <div class="region-wrap">
                            <div>
                                <input id="isOnline" type="checkbox" name="isOnline"/>
                                <label for="isOnline">온라인 진행</label>
                            </div>
                            <select id="region-sel" name="region">
                            @foreach($data['region'] as $key => $val)
                                <option value="{{$key}}" title="{{$val['name']}}" {{ $data['study']['region_id'] === $val['name'] ?? "selected" }} >{{$val['name']}}</option>
                            @endforeach
                            </select>
                        </div>
                    </td>
                    <th>상세 주소<span class="helper-text">(선택)</span></th>
                    <td><input type="text" name="location"></td>
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
                        <input type="text" name="titlename">
                    </td>
                </tr>
            </table>
            <textarea style="width: 100%" name="ir1" id="ir1" rows="10" cols="100">에디터에 기본으로 삽입할 글(수정 모드)이 없다면 이 value 값을 지정하지 않으시면 됩니다.</textarea>
        </div>
    </div>
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

        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            showAnim: 'slideDown'
        });

    }
    const sendData= (f) => {
        console.log(f);
        const formData = new FormData(f);
        console.log(formData);
        // 폼 객체 key 와 value 값을 순회.
        let entries = formData.entries();
        for (const pair of entries) {
            console.log(pair[0]+ ', ' + pair[1]); 
        }

        $.ajax({
            url: '/study/write',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                alert(res.msg);
            },
            error: function(err) {
                console.error('AJAX 요청 실패', err);
            }
        });

        
    }
</script>
@endsection