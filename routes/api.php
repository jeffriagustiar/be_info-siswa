<?php

use App\Http\Controllers\API\SiswaController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function(){
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('update', [UserController::class, 'updateProfile']);
    Route::get('dataUser', [UserController::class, 'fetch']);
    
    //Data SPP siswa
    Route::get('dataSpp', [SiswaController::class, 'sppSiswa']);
    Route::get('sppDetail', [SiswaController::class, 'sppDetail']);

    //Data Siswa
    Route::get('dataSiswa', [SiswaController::class, 'all']);

    //Data Nilai Siswa
    Route::get('nilaiRapor', [SiswaController::class, 'nilaiRapor']);
    Route::get('nilaiRaporD', [SiswaController::class, 'nilaiRaporD']);
    Route::get('nilaiRaporPancasila', [SiswaController::class, 'nilaiRaporPancasila']);

        //Data Nilai Harian
        Route::get('nilaiHarian', [SiswaController::class, 'nilaiHarian']);
        Route::get('nilaiHarianJenis', [SiswaController::class, 'nilaiHarianJenis']);
        Route::get('mapelNilai', [SiswaController::class, 'mapelNilai']);
    
    //Data Absen Siswa
    Route::get('absenHarianSiswa', [SiswaController::class, 'pHarianSiswa']);
    Route::get('absenHarianSiswaHitung', [SiswaController::class, 'pHarianSiswaHitung']);

        //Data Absen Pelajaran
        Route::get('absenPelajaran', [SiswaController::class, 'absenPelajaran']);
        Route::get('absenPelajaranDetail', [SiswaController::class, 'absenPelajaranDetail']);

    //Data Tahun Ajaran
    Route::get('tahun', [SiswaController::class, 'tahun']);
    
});
Route::get('semester', [SiswaController::class, 'semester']);
Route::get('mapel', [SiswaController::class, 'maple']);
Route::get('tahunAbsen', [SiswaController::class, 'tahunAbsen']);

Route::post('login', [UserController::class, 'login']);
