<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KtpController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//ambil semua data
Route::get('/ktps', [KtpController::class, 'index']);

//tambah data baru
Route::post('ktps/tambah-data', [KtpController::class, 'store']);

//generate token csrf
Route::get('generate-token', [KtpController::class, 'createToken']);

//untuk menampilkan data yg sudah di hapus sementara oleh softdelete
Route::get('/ktps/show/traimage.pngsh', [KtpController::class, 'trash']);

//ambil satu data spesifik
Route::get('/ktps/{id}', [KtpController::class, 'show']);

//mengubah data tertentu
Route::patch('/ktps/update/{id}', [KtpController::class, 'update']);

//menghapus data tertentu
Route::delete('/ktps/delete/{id}', [KtpController::class, 'destroy']);

//mengembalikan data spesifik yang sudah di hapus
Route::get('ktps/trash/restore/{id}', [KtpController::class, 'restore']);

//menghapus permanen data tertentu 
Route::get('/ktps/trash/delete/permanent/{id}', [KtpController::class, 'permanentDelete']);