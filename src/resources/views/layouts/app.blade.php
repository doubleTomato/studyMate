<!DOCTYPE html>
<html lang="ko">
    @include('common.header')
<body>
    <main>
        @yield('content')
    </main>
    <div class="loading-sec">
        @include('common.modal')
    </div>
    <div class="modal-sec"></div>
    @include('common.footer')
    <script>
        $(document).ready(function() {
            $('.select2-basic').select2({
                width: 'resolve'
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