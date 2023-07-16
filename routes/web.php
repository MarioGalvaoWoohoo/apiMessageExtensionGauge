<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthAppController;
use App\Http\Controllers\HomeController;

Route::get('/login', [AuthAppController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthAppController::class, 'loginApp']);


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
});

