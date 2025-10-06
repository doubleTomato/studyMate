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
                        <pre class="scroll-box">{{$val -> content}}간때문이야~ 피로는간때문이야rkskekfkakqktkdkwkk카타파아하당럳자ㅓ랒머라ㅣㅁㅈ더라ㅣ점ㄷ라ㅣ멎다ㅣ럼ㅈ디ㅏ럼자ㅣ덜자미;ㅓㄹ자ㅣ;멀ㅈㅁ다ㅓ리자머리ㅏ저리ㅏ젇라ㅣㅈ머라ㅣㅁ저라ㅣ먿가ㅣㅓㄹ마저ㅏㅣㅈㄹ머ㅣㅏㅈㄹ머ㅣㅏㅈ렂ㄷ라ㅣㅓㅈㄹ다ㅓㄹㅈㄷ</pre></dd>
                </dl>
            </li>
            @endforeach
        </ul>
    </div>
    @endsection
    @section('button')
    @endsection
