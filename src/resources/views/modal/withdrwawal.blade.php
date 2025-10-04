@extends('layouts.modal')
    @section('title')
        회원 탈퇴
    @endsection
    @section('content')
        <div class="withdrwawal-wrap">
            <ul>
                <li>탈퇴하시면 회원님의 소중한 활동 기록이 모두 사라지게 됩니다.</li>
                <li>함께했던 스터디 기록, 작성하셨던 게시글과 댓글들이 모두 삭제되며 다시는 찾아볼 수 없게 돼요.</li>
                <li>정말 괜찮으시다면, 아래 '탈퇴하기'를 눌러주세요. 언젠가 다시 만나 뵐 수 있기를 바랄게요.</li>
            </ul>
            <div>
                <input type="checkbox" id="check-withdrwawal"/>
                <label for="check-withdrwawal">위 내용을 모두 확인했으며, 정보 삭제에 동의합니다.</label>
            </div>
        </div>
    @endsection
    @section('button')
         <button id="withdrwawal-btn" disabled class="delete-btn" type="button" onclick="profileUpdate(null, 'DELETE')">탈퇴하기</button>
    @endsection

    <script>
        $("#check-withdrwawal").on('click',function(){
            if($(this).prop('checked')){
                $('#withdrwawal-btn').prop("disabled",false);
            }else{
                $('#withdrwawal-btn').prop("disabled",true);
            }
        })
    </script>