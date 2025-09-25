<?php
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LookupGetInfo;
use App\Http\Controllers\StudiesCrudController;
use App\Http\Controllers\MypageCrudController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\ImageUploadController;

use App\Http\Controllers\Auth\AuthController;

use Illuminate\Support\Facades\Route;


//페이지
Route::get('/', function () { return view('home'); }); //home
Route::get('/login', function () { return view('login'); }) -> name('login') ; //로그인
//Route::get('/signup', function () { return view('signup.step1'); }) -> name('signup'); //회원가입
Route::get('/write', function () { return view('write'); }); // 작성
// Route::get('/mypage', function () { return view('mypage'); }); // 마이페이지
Route::get('/settings', function () { return view('settings'); }); // 설정
Route::get('/search', function () { return view('search'); }); // 검색


// 회원가입
Route::get('/signup', function(){ return view('signup.signup'); })->name('signup');
Route::post('/signup', [SignupController::class, 'signup'])->name('signup.post');

// 닉네임 중복확인
Route::post('/nickname/duplicate', [SignupController::class, 'nicknameDuplicate'])->name('signup.nickname');

// 이메일 인증 관련
Route::get('/verifyemail', [AuthController::class, 'verifyEmail'])->name('verify.email'); //이메일 인증 메일 폼
Route::post('/email/send-code', [EmailVerificationController::class, 'sendCode'])->name('email.send.code');//메일로 코드 전송
Route::post('/email/verify-code', [EmailVerificationController::class, 'verifyCode'])->name('email.verify.code'); // 코드 인증

// 로그인
Route::post('/login/post', [AuthController::class, 'store'])
                ->name('login.post');
// 로그아웃
Route::post('/logout', [AuthController::class, 'logout'])
                ->middleware('auth')
                ->name('logout');


// controller연결
//Route::resource('/posts', [AuthController::class, 'register']);
Route::get('/category/default', [LookupGetInfo::class, 'getDefaultCategory']);
Route::get('/regions/default', [LookupGetInfo::class, 'getDefaultRegions']);

// study crud
Route::resource('/study',StudiesCrudController::class);

//mypage ru
Route::resource('/mypage',MypageCrudController::class);

Route::get('/mypage/mystudy/{id}', function ($id) { return view('mypage.mystudy'); }); // 생성 스터디 전체
Route::get('/mypage/participation/{id}', function ($id) { return view('mypage.participation'); }); // 참가 스터디 전체


// api
Route::post('/studies/list', [StudyController::class, 'getOrderList']);