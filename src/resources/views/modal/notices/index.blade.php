@extends('layouts.modal')
    @csrf
    @section('title')
        공지 전체보기
    @endsection
    @section('content')
    <div class="notice-all-list">
        <ul class="notice-list">
            @foreach($notices as $key => $val)
            <li>
                <dl>
                    <dt>
                        @if($val->is_crucial === 1)
                        <span class="important-txt cm-label important">필독 !</span>
                        @endif
                        <p class="title">{{$val -> title}}</p>
                    </dt>
                    <dd>
                        <pre class="scroll-box">{{$val -> content}}</pre></dd>
                </dl>
            </li>
            @endforeach
        </ul>
    </div>
    @endsection
    @section('button')
    @endsection
