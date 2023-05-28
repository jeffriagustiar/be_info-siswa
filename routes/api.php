<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GuruController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\SiswaController;

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
    //Siswa
    //? untuk mengolah data siswa

    Route::post('logout', [UserController::class, 'logout']);
    Route::post('update', [UserController::class, 'updateProfile']);
    Route::get('dataUser', [UserController::class, 'fetch']);
    
    //Data SPP siswa
    Route::get('dataSpp', [SiswaController::class, 'sppSiswa']);
    Route::get('sppDetail', [SiswaController::class, 'sppDetail']);

    //Data Siswa
    Route::get('dataSiswa', [SiswaController::class, 'all']);

    //Data Nilai Rapor Siswa
    Route::get('nilaiRapor', [SiswaController::class, 'nilaiRapor']);
    Route::get('nilaiRaporD', [SiswaController::class, 'nilaiRaporD']);
    Route::get('mapelNilaiRaporPancasila', [SiswaController::class, 'mapelNilaiRaporPancasila']);
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
        
        //Data Absen Per Pelajaran
        Route::get('MapelAbsenPerPelajaran', [SiswaController::class, 'absenPerPelajaranMapel']);
        Route::get('MapelAbsenPerPelajaranDetail', [SiswaController::class, 'absenPerPelajaranMapelDetail']);

    //Ambil Absen Siswa
    Route::get('koordinatLokasiSekolah', [SiswaController::class, 'koordinatLokasiSekolah']);
    Route::get('koordinatLokasiSekolahSatu', [SiswaController::class, 'koordinatLokasiSekolahSatu']);
    Route::get('cekSudahAbsenSiswa', [SiswaController::class, 'cekSudahAbsenSiswa']);
    Route::post('ambilAbsenSiswa', [SiswaController::class, 'AbsenSiswa']);
    
    //Data Catatan Siswa
    Route::get('catatanSiswa', [SiswaController::class, 'catatanSiswa']);
    Route::get('totalPointSiswa', [SiswaController::class, 'pointSiswa']);
    
    
    //Data Siswa Tercepat Absen
    Route::get('siswaTercepatAmbilAbsen', [SiswaController::class, 'tercepatAmbilAbsen']);
    //Data Tahun Ajaran
    Route::get('tahun', [SiswaController::class, 'tahun']);
    //Data Semester
    Route::get('semester', [SiswaController::class, 'semester']);
    //Data Mapel
    Route::get('mapel', [SiswaController::class, 'maple']);


    
});

Route::middleware('auth:api2')->group(function(){
    //Guru
    //? untuk mengolah data guru

    Route::post('logoutGuru', [UserController::class, 'logoutGuru']);

    //data guru
    Route::get('dataGuru', [UserController::class, 'dataGuru']);

    //laporkan siswa
    //? buat laporan
    Route::post('laporkanSiswa', [GuruController::class, 'laporkanSiswa']);

    //Data Tatatertib Sekolah
    Route::get('catatanGuru', [SiswaController::class, 'catatan']);
});

//Data Tatatertib Sekolah
Route::get('catatan', [SiswaController::class, 'catatan']);

//Data Semua Siswa
Route::get('dataSemuaSiswa', [GuruController::class, 'dataSiswa']);

//Data Tatatertip
Route::get('dataSemuaKategori', [GuruController::class, 'dataKategori']);
Route::get('dataSemuaJenis', [GuruController::class, 'dataJenis']);


//Data Jadwal Pelajaran
Route::get('jadwalPelajaran', [SiswaController::class, 'jadwalPelajaran']);
Route::get('test', [SiswaController::class, 'test']);

//Data Tahun Absen 
Route::get('tahunAbsen', [SiswaController::class, 'tahunAbsen']);

//Login Siswa
Route::post('login', [UserController::class, 'login']);

//Login Guru
Route::post('loginGuru', [UserController::class, 'loginGuru']);
