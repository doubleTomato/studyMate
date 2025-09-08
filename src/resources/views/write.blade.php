{{-- 스터디 모집 글 생성 --}}
@extends('layouts.app')
@section('content')
<script type="text/javascript" src="{{ asset('plugin/se2/js/service/HuskyEZCreator.js') }}" charset="utf-8"></script>
<section class="write-sec">
    <form method="POST" action="/create">
        @csrf
        <div class="content-tit">
            <div class="image-con">
                이미지
            </div>
            <div class="information">
                <dl>
                    <dt>제목</dt>
                    <dd>
                        <input type="text" name="titlename">
                    </dd>
                </dl>
                <dl>
                    <dt>모집 마감일</dt>
                    <dd>
                        <input type="text" name="titlename">
                    </dd>
                </dl>
                <dl>
                    <dt>지역(온라인 여부)</dt>
                    <dd>
                        <select name="location">
                            <option>1</option>
                        </select>
                        <label for="isOnline">온라인 가능 여부</label>
                        <input id="isOnline" type="checkbox" name="isOnline"/>
                    </dd>
                </dl>
                <dl>
                    <dt>설명</dt>
                    <dd>
                        <textarea name="ir1" id="ir1" rows="10" cols="100">에디터에 기본으로 삽입할 글(수정 모드)이 없다면 이 value 값을 지정하지 않으시면 됩니다.</textarea>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="content-con">

        </div>
    </form>
</section>
<script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "ir1",
        sSkinURI: "{{ asset('plugin/se2/SmartEditor2Skin.html') }}",
        fCreator: "createSEditor2"
    });
</script>
@endsection