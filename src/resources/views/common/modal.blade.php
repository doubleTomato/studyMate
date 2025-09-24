<div class="msg alert">
    <div class="msg-con-wrap">
        <h1><span class="msg-con">등록</span> 중 입니다.</h1>
    </div>
    <p>잠시만 기다려주세요.</p>
    <div>
        <i class="xi-spinner-5 xi-spin"></i>
    </div>
</div>

{{-- button 포함된 alert --}}
<div class="msg alert-btn">
    <div class="msg-con-wrap">
    </div>
    <div class="modal-buttons">
        <button type="button" class="close-btn" onclick="APP_FUNC.commonFunc.modalHide('alert-btn')">
            확인
        </button>
    </div>
</div>

<div class="msg response">
    <div class="msg-con-wrap">
        <p class="state-icon">
            <i class="xi-check-circle xi-3x"></i>
        </p>
        <h1><span class="msg-con">등록</span>이 완료되었습니다.</h1>
    </div>
</div>

<div class="msg confirm">
    <div class="msg-con-wrap">
        <h1>삭제</h1>
        <p class="state-icon">
            <i class="xi-check-circle xi-3x"></i>
        </p>
        <p>삭제하면 되돌릴 수 없습니다. 계속하시겠습니까?</p>
    </div>
    <div class="modal-buttons">
        <button id="modal-close-btn" type="button">취소</button>
        <button id="modal-ok-btn" class="delete-btn" type="button">삭제</button>
    </div>
</div>

<div class="msg modal">
    <div class="close-btn" onclick="APP_FUNC.commonFunc.modalHide('modal')">
        <i class="xi-close"></i>
    </div>
    <div class="modal-head">
        <h1>타이틀</h1>
    </div>
    <div class="modal-con">
        <p>아마도 내용이 들어갈 공간</p>
    </div>
    <div class="modal-buttons">
        <button type="button" onclick="APP_FUNC.commonFunc.modalHide('modal')">닫기</button>
        <button class="cta-btn" type="button">action</button>
    </div>
</div>