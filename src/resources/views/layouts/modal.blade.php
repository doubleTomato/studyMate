<div class="modal-wrap-box">
    <div class="close-btn" onclick="APP_FUNC.commonFunc.popupHide('modal')">
        <i class="xi-close"></i>
    </div>
    <div class="modal-head">
        <h1>@yield('title')</h1>
    </div>
    <div class="modal-con">
        @yield('content')
    </div>
    <div class="modal-buttons">
        <button type="button" onclick="APP_FUNC.commonFunc.popupHide('modal')">닫기</button>
        @yield('button')
    </div>
</div>
