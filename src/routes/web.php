<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LookupGetInfo;
use App\Http\Controllers\StudiesCrudController;
use App\Http\Controllers\StudyController;
use Illuminate\Support\Facades\Route;

//페이지
Route::get('/', function () { return view('home'); }); //home
Route::get('/login', function () { return view('login'); }) -> name('login') ; //로그인
Route::get('/signup', function () { return view('signup.signup'); }) -> name('signup'); //회원가입
Route::get('/write', function () { return view('write'); }); // 작성
Route::get('/mypage', function () { return view('mypage'); }); // 마이페이지
Route::get('/settings', function () { return view('settings'); }); // 설정
Route::get('/search', function () { return view('search'); }); // 검색




Route::get('/verifyemail', [AuthController::class, 'verifyEmail'])->name('verify.email');

// controller연결
//Route::resource('/posts', [AuthController::class, 'register']);
Route::get('/category/default', [LookupGetInfo::class, 'getDefaultCategory']);
Route::get('/regions/default', [LookupGetInfo::class, 'getDefaultRegions']);

// study crud
Route::resource('/study',StudiesCrudController::class);

// api
Route::post('/studies/list', [StudyController::class, 'getOrderList']);