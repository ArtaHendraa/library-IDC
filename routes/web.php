<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/post', function () {
    return view('post');
});
Route::get('/edit', function () {
    return view('edit');
});
