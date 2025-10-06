@extends('layouts.modal')
    @csrf
    @section('title')
        공지 수정
    @endsection
    @section('content')
     <form action="#" method="POST" name="notice-form">
        <div class="notices-wrap">
            <ul class="info-list">
                <li>
                    <div class="label">제목</div>
                    <div class="value">
                        <input class="input-data" id="notice-title" type="text" readonly name="title" value="{{$notices['title']}}" placeholder="제목을 입력해주세요.">
                    </div>
                </li>
                <li>
                    <div class="label">내용</div>
                    <div class="value">
                        <textarea readonly class="input-data" id="notice-content" onclick="" name="content" placeholder="공지 내용을 입력해주세요" name="content">{{$notices['content']}}</textarea>
                    </div>
                </li>
                <li>
                    <div class="label">필독<span class="helper-text">(선택)</span></div>
                    <div class="value" style='text-align: left'>
                        <input disabled id="isCrucial" value="1" type='checkbox' class="input-data"  name="is_crucial" {{$notices['is_crucial'] === 1? 'checked':''}}/>
                        <label for="isCrucial"></label>
                    </div>
                </li>
            </ul>
        </div>
    </form>
    @endsection
    @section('button')
         <button class="delete-btn" id="notice-delete-btn" type="button" onclick="APP_FUNC.commonFunc.commonSendForm( null, 'DELETE', '/notice/{{ $notices['id'] }}', '공지가 삭제')">삭제</button>
         <button class="" id="notice-edit-btn" type="button" onclick="noticeSend('notice','PUT')">수정하기</button>
    @endsection

    <script>
       function noticeSend(f, methodType){

            if($("#notice-title").prop('readonly')){
                $("#isCrucial").prop('disabled',false);
                $("#notice-title").prop('readonly', false);
                $("#notice-content").prop('readonly', false);
            }else{
                $("#notice-edit-btn").prop("disabled", true);
                const formEl = $(`form[name=${f}-form]`);
                const formData = new FormData(formEl.get(0));
                //formData.append('_method', 'PUT');
                APP_FUNC.commonFunc.commonSendForm( formData, methodType, '/notice/{{ $notices['id'] }}', '공지가 수정');
            }
        }
    </script>
