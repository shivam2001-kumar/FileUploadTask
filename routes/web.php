<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
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
Route::get('/',[FileController::class,'index'])->name('home');

Route::post('upload',[FileController::class,'upload'])->name('upload');

Route::DELETE('delete/{id}',[FileController::class,'delete'])->name('delete');

Route::get('/download/{filename}', [FileController::class,'download'])->name('download.file');
