@php
    use Carbon\Carbon;
    $today = new DateTime();
    $deadlineDate = DateTime::createFromFormat('Y-m-d',  $data['study']['deadline']);
    $isClosed = $today > $deadlineDate || count($data['participants']) === $data['study']['max_members'];
@endphp
{{-- 스터디 모집 글 수정 --}}
@extends('layouts.app')
@section('content')
<script type="text/javascript" src="{{ asset('plugin/se2/js/service/HuskyEZCreator.js') }}" charset="utf-8"></script>
<section class="write-sec">
    <form method="POST" action="#">
        @csrf
        @method('patch')
        <input type="hidden" name="study-id" value="{{ $data['study']['id'] }}"/>
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
                                @foreach($data['category'] as $key => $val)
                                    <option value="{{ $key }}" {{$data['study']['category_id'] === $key ? 'selected' :''}}>{{$val['title']}}</option>
                                @endforeach
                            </select>
                        </td>
                        <th>모집 인원</th>
                        <td>
                            <input type="number" name="recruited-num" required value="{{ $data['study']['max_members'] }}">
                        </td>
                    </tr>
                    <tr>
                        <th>모집 마감일<i class="xi-calendar"/></th>
                        <td>
                            <input type="text" class="datepicker" id="deadLine" name="deadline-date" required value="{{ $data['study']['deadline'] }}">
                        </td>
                        <th>스터디 기간<i class="xi-calendar"/></th>
                        <td>
                            <div class="datetime-wrap">
                                <input type="text" class="datepicker" id="start-date" name="start-date" required value="{{ $data['study']['start_date'] }}">
                                <span>~</span>
                                <input type="text" class="datepicker"  id="end-date" name="end-date" value="{{ $data['study']['end_date'] }}" {{ empty($data['study']['end_date']) ?'disabled':'' }}>
                            </div>
                            <div class="datetime-duration-disable">
                                <input {{empty($data['study']['end_date']) ?'checked':''}} onclick="APP_FUNC.inputFunc.checkDisabled(this, ['end-date'])" id="durationdisable" type="checkbox" name="durationdisable"/>
                                <label for="durationdisable">기간 제한 없음</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>지역</th>
                        <td>
                            <div class="region-wrap">
                                <div>
                                    <input {{$data['study']['is_offline'] === 1 ? 'checked' : ''}} onclick="APP_FUNC.inputFunc.checkDisabled(this, ['region-sel','location'])" id="is-offline" type="checkbox" name="is-offline" value="1"/>
                                    <label for="is-offline">온라인 진행</label>
                                </div>
                                <select class="select2-basic" id="region-sel" name="region" {{$data['study']['is_offline'] === 1 ? 'disabled' : ''}}>
                                    <option value="">선택해주세요.</option>
                                    @foreach($data['region'] as $key => $val)
                                    <option value="{{ $key }}" {{$data['study']['region_id'] === $key ? 'selected':''}}>{{$val['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <th>상세 주소<span class="helper-text">(선택)</span></th>
                        <td><input type="text" name="location" id="location" value="{{ $data['study']['location'] }}" {{$data['study']['is_offline'] === 1 ? 'disabled' : '' }}></td>
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
                            <input type="text" name="titlename" required value="{{ $data['study']['title'] }}">
                        </td>
                    </tr>
                </table>
                <textarea required style="width: 100%" name="ir1" id="ir1" rows="10" cols="100">
                    {{$data['study']['description']}}
                </textarea>
            </div>
        </div>
        <div class="button-con">
            <a class="cm-btn" href="{{ route('study.show', $data['study']['id']) }}">취소</a>
            <button class="cta-btn" type="button" onclick="APP_FUNC.inputFunc.sendData(this.form,'PUT', '/{{$data['study']['id']}}')">수정하기</button>
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
        fCreator: "createSEditor2",
    });
    window.onload = function(){
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            showAnim: 'slideDown'
        });
    }

</script>
@endsection
@section('loading-msg')
@endsection