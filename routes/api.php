<?php

use App\Http\Controllers\Api\ArtikelController;
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

Route::apiResource('/kategoris', App\Http\Controllers\Api\KategoriController::class);
Route::apiResource('/artikels', App\Http\Controllers\Api\ArtikelController::class);
Route::apiResource('/komentars', App\Http\Controllers\Api\KomentarController::class);
Route::apiResource('/users', App\Http\Controllers\Api\UserController::class);

Route::get('/indexartikel',[ArtikelController::class,'indexartikel']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
