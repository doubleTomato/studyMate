<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('home'); }); //home
Route::get('/login', function () { return view('login'); }); //로그인
Route::get('/signup', function () { return view('signup'); }); //회원가입
Route::get('/write', function () { return view('write'); }); // 작성
Route::get('/modify', function () { return view('modify'); }); // 수정
Route::get('/detail', function () { return view('detail'); }); // 상세
Route::get('/mypage', function () { return view('mypage'); }); // 마이페이지
Route::get('/settings', function () { return view('settings'); }); // 설정
Route::get('/search', function () { return view('search'); }); // 검색

