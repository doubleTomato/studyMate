@php
    $cur_route = Route::current();
    $route_name = $cur_route->getName();
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('xeicon/xeicon.min.css') }}">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    {{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @vite(['resources/css/scss/main.scss', 'resources/js/app.js'])
    <script type="text/javascript" src="{{ asset('plugin/se2/js/service/HuskyEZCreator.js') }}" charset="utf-8"></script>
</head>

<nav class="header">
    <div class="flex-wrap">
        <div class="logo">
            <a href="{{ route('study.index') }}">
                <img src="{{ asset('images/studymate_bk_none_logo.png') }}" alt="Logo">
            </a>
            {{-- <img src="{{ asset('images/studymate_bk_none_logo_s.png') }}" alt="Logo"> --}}
        </div>
        <ul class="flex-wrap">
            <li>
                <a class="cm-btn cta-btn icon-btn {{ $route_name === 'study.create' ? 'active':'' }}" href="{{route("study.create")}}">
                    <span>스터디 만들기</span>
                    <span><i class="xi-plus"></i></span>
                </a>
            </li>
            <li class="{{ $route_name === 'study.index' ? 'active':'' }}">
                <a href="{{route("study.index")}}">
                    <span>스터디 찾기</span>
                </a>
            </li>
            <li class="username {{ $route_name === 'mypage.profile' ? 'active':'' }}"> 
                @auth
                <div class="flex-wrap" style="gap:10px;">
                    <p class="username-user"><span>{{ Auth::user()->nickname }}</span><span>님</span> <i class="xi-caret-down-min"></i></p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button title="logout" class="logout" type="submit"><i class="xi-log-out"></i></button>
                    </form>
                </div>
                <ul class="mypage-dropdown">
                    <li><a href="{{ route('mypage.edit', auth() -> id()) }}">내 프로필</a></li>
                    <li><a href="{{ route('mypage.mystudy') }}">생성한 스터디</a></li>
                    <li><a href="{{ route('mypage.participation') }}">참여 스터디</a></li>
                </ul>
                @endauth
    
                @guest
                    <div>
                        <a class="login-link" href="{{route('login')}}">로그인</a>
                    </div>
                    {{-- <a href="/register">회원가입</a> --}}
                @endguest
            </li>
        </ul>
    </div>
</nav>