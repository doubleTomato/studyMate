@extends('layouts.app')
@section('content')

<section class="list-sec mystudy-sec">
    <div class="content">
        <div class="head-con flex-wrap">
            <h1>내가 생성한 스터디</h1>
            <span>
                <a href="/mypage/mystudy/1">
                    더보기<i class="xi-angle-right-min"></i>
                </a>
            </span>
        </div>
        <div class="filter-list">
            <div class="list active">전체</div>
            <div class="list">진행중</div>
            <div class="list">마감</div>
        </div>
        <div class="content">
            <ul id="study-list" class="list-wrap">
                <li class="list">
                    <a href="http://localhost:8080/study/1">
                        <div class="flex-wrap">
                            <p class="list-tit" title="대구찜이아니라 아구찜이지 이자식!!">
                                대구찜이아니라 아구찜이지 이자식!!
                            </p>
                            <div class="list-deadline">
                                <span class="">D-65</span>
                                <span class="helper-text">(2025-11-29)</span>
                            </div>
                        </div>

                        <div>
                            <p>
                                <i class="xi-marker-circle"></i>
                            </p>
                            <p>Online</p>
                        </div>
                        <div>
                            <p><i class="xi-calendar"></i></p>
                            2025-09-30 ~ 2025-11-30
                        </div>
                        <div class="participants-wrap">
                            <div class="participants-count">
                                <p><i class="xi-community"></i></p>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 5%"></div>
                                    <div>
                                        <span>1</span>
                                        <span>/</span>
                                        <span>
                                            20
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <ul class="participants-profile">
                                    <li><i class="xi-user"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex-wrap left">
                            <p><i class="xi-label"></i></p>
                            <p class="cm-label category">
                                <span>자격증</span>
                            </p>
                        </div>
                        <div class="flex-wrap">
                            <p>
                                <span><i class="xi-eye-o"></i></span>
                                <span>0</span>
                            </p>
                            <p class="flex-wrap left                        ">
                                <span><i class="xi-calendar"></i></span>
                                <span class="helper-text">2025-09-24 10:29:43</span>
                            </p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <hr>
    <div>
        <div class="head-con flex-wrap">
            <h1>참가 스터디</h1>
            <span>
                <a href="/mypage/participation/1">
                    더보기<i class="xi-angle-right-min"></i>
                </a>
            </span>
        </div>
        <div class="filter-list">
            <div class="list active">전체</div>
            <div class="list">진행중</div>
            <div class="list">마감</div>
        </div>
        <div class="content">
            <ul id="study-list" class="list-wrap">
                <li class="list ">
                    <a href="http://localhost:8080/study/1">
                        <div class="flex-wrap">
                            <p class="list-tit" title="대구찜이아니라 아구찜이지 이자식!!">
                                대구찜이아니라 아구찜이지 이자식!!
                            </p>
                            <div class="list-deadline">
                                <span class="">D-65</span>
                                <span class="helper-text">(2025-11-29)</span>
                            </div>
                        </div>

                        <div>
                            <p>
                                <i class="xi-marker-circle"></i>
                            </p>
                            <p>Online</p>
                        </div>
                        <div>
                            <p><i class="xi-calendar"></i></p>
                            2025-09-30 ~ 2025-11-30
                        </div>
                        <div class="participants-wrap">
                            <div class="participants-count">
                                <p><i class="xi-community"></i></p>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 5%"></div>
                                    <div>
                                        <span>1</span>
                                        <span>/</span>
                                        <span>
                                            20
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <ul class="participants-profile">
                                    <li><i class="xi-user"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex-wrap left">
                            <p><i class="xi-label"></i></p>
                            <p class="cm-label category">
                                <span>자격증</span>
                            </p>
                        </div>
                        <div class="flex-wrap">
                            <p>
                                <span><i class="xi-eye-o"></i></span>
                                <span>0</span>
                            </p>
                            <p class="flex-wrap left                        ">
                                <span><i class="xi-calendar"></i></span>
                                <span class="helper-text">2025-09-24 10:29:43</span>
                            </p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>
@endsection