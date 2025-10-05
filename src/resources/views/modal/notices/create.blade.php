@extends('layouts.modal')
    @csrf
    @section('title')
        공지 작성
    @endsection
    @section('content')
     <form action="#" method="POST" name="notice-form">
        <div class="notices-wrap">
            <ul class="info-list">
                <li>
                    <div class="label">제목</div>
                    <div class="value">
                        <input class="input-data" id="notice-title" type="text" name="title" value="" placeholder="제목을 입력해주세요.">
                    </div>
                </li>
                <li>
                    <div class="label">내용</div>
                    <div class="value">
                        <textarea class="input-data" id="notice-content" onclick="" name="content" placeholder="공지 내용을 입력해주세요" name="content"></textarea>
                    </div>
                </li>
                <li>
                    <div class="label">필독<span class="helper-text">(선택)</span></div>
                    <div class="value" style='text-align: left'>
                        <input id="isCrucial" value="1" type='checkbox' class="input-data"  name="is_crucial"/>
                        <label for="isCrucial"></label>
                    </div>
                </li>
            </ul>
        </div>
    </form>
    @endsection
    @section('button')
         <button id="notice-create-btn" type="button" onclick="noticeSend('notice-form')">작성하기</button>
    @endsection

    <script>
        $(".input-data").on('input',()=>{
            noticeSend();
        })
    </script>
