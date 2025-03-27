<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProductController::class, 'index'])->middleware('auth');

Route::get('/login', [LoginController::class, 'login']);
Route::post('/login', [LoginController::class, 'loginPost'])->name('login');

Route::get('/register', [LoginController::class, 'register']);
Route::post('/register', [LoginController::class, 'registerPost'])->name('register');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');