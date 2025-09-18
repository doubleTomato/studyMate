<!DOCTYPE html>
<html lang="ko">
    @include('common.header')
<body>
    <main>
        @yield('content')
    </main>
    <div class="loading-sec">
        <div class="msg">
            @yield('loading-msg')
            <h1><span class="msg-con">등록</span> 중 입니다.</h1>
            <p>잠시만 기다려주세요.</p>
            <div>
                <i class="xi-spinner-5 xi-spin"></i>
            </div>
        </div>
    </div>
    @include('common.footer')
    <script>
        $(document).ready(function() {
            $('.select2-basic').select2({
                width: 'auto'
            });
        });
    </script>
    <aside class="top-btn" title="맨 위로">
        <a href="#">
            <i class="xi-arrow-top xi-2x"></i>
        </a>
    </aside>
</body>
</html>