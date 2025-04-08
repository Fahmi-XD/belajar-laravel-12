<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/product', [ProductController::class,'delete']);

// Crud barang
Route::get('/barang', [BarangController::class, 'index']);
Route::post('/barang', [BarangController::class, 'create']);
Route::patch('/barang', [BarangController::class, 'update']);
Route::delete('/barang', [BarangController::class, 'remove']);

// Crud admin
Route::post('/admin', [AdminController::class, 'create']);
Route::get('/admin', [AdminController::class, 'index']);

// Admin login / Logout
Route::post('/admin/login', [AdminController::class, 'loginPost']);
Route::get('/admin/logout', [AdminController::class, 'logout']);

// Moderator
Route::get("/moderator", [ModeratorController::class, 'index']);