<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/jalans', [ApiController::class, 'index'])->name('api.jalans');
Route::get('/batasdesa', [ApiController::class, 'batas_desa'])->name('api.batas.desa');
Route::get('/bataskecamatan', [ApiController::class, 'batas_kecamatan'])->name('api.batas.kecamatan');
Route::get('/bataskabupaten', [ApiController::class, 'batas_kabupaten'])->name('api.batas.kabupaten');
Route::get('/bangunanperibadatan', [ApiController::class, 'bangunan_peribadatan'])->name('api.bangunan.peribadatan');