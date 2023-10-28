<?php

use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\KomentarController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');

Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

Route::apiResource('/kategoris', App\Http\Controllers\Api\KategoriController::class);
Route::apiResource('/artikels', App\Http\Controllers\Api\ArtikelController::class);
Route::apiResource('/komentars', App\Http\Controllers\Api\KomentarController::class);
Route::apiResource('/users', App\Http\Controllers\Api\UserController::class);

Route::get('/indexkategori',[KategoriController::class,'indexkategori']);
Route::get('/indexartikel',[ArtikelController::class,'indexartikel']);
Route::get('/indexartikel1',[ArtikelController::class,'indexartikel1']);
Route::get('/indexkomentar',[KomentarController::class,'indexkomentar']);
Route::get('/indexuser',[UserController::class,'indexuser']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
