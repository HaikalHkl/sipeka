<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/dashboardbootstrap', function () {
    return view('dashboardbootstrap');
})->middleware(['auth'])->name('dashboardbootstrap');

Route::get('/coa', 'CoaController@index');
Route::post('/coa', 'CoaController@store')->middleware(['auth']);

// route coa
Route::get('/coa', [App\Http\Controllers\CoaController::class, 'index']);

// untuk master data coa
// jika ingin menambahkan routes baru selain default resource di tambah di awal
// sebelum route resource
Route::get('coa/tabel', [App\Http\Controllers\CoaController::class,'tabel'])->middleware(['auth']);
Route::get('coa/fetchcoa', [App\Http\Controllers\CoaController::class,'fetchcoa'])->middleware(['auth']);
Route::get('coa/fetchAll', [App\Http\Controllers\CoaController::class,'fetchAll'])->middleware(['auth']);
Route::get('coa/edit/{id}', [App\Http\Controllers\CoaController::class,'edit'])->middleware(['auth']);
Route::get('coa/destroy/{id}', [App\Http\Controllers\CoaController::class,'destroy'])->middleware(['auth']);
Route::post('/coa/store', [CoaController::class, 'store'])->name('coa.store');
Route::resource('coa', CoaController::class)->middleware(['auth']);
require __DIR__.'/auth.php';
