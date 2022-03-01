<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\TransportController;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart', [DashboardController::class, 'chart']);
    Route::get('/dashboard/export', [DashboardController::class, 'exportexcel']);
    Route::get('/dashboard/exportpdf', [DashboardController::class, 'exportpdf']);

    Route::resource('user', UserController::class);
    Route::resource('employee', EmployeeController::class);
    Route::resource('transport', TransportController::class);

    Route::resource('rental', RentalController::class);
    Route::post('acc/{rental}', [RentalController::class, 'acc'])->name('rental.acc')->middleware('role:kabag_umum,kabag_pegawai');


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
