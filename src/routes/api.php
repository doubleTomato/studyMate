<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    return ['message' => 'API 테스트 성공'];
});
