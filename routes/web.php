<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\KasbonController;
use App\Http\Controllers\EndUserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReimburseController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PaidProjectController;
use App\Http\Controllers\PriceSubmitController;
use App\Http\Controllers\PaidDeveloperController;
use App\Http\Controllers\PriceDeveloperController;
use App\Http\Controllers\TunjanganHariRayaController;

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

Route::middleware(['web', 'disableBackButton'])->group(function(){
    Route::middleware(['disableRedirect'])->group(function(){
        Route::get('/', [Controller::class, 'login'])->name('login');
        Route::get('/login', [Controller::class, 'login'])->name('login');
        Route::post('/post-login', [Controller::class, 'postLogin'])->name('post-login');
    });

    Route::get('/logout', [Controller::class, 'logout'])->name('logout');
});

Route::middleware(['auth:web', 'disableBackButton'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('/role', RoleController::class);
    Route::resource('/permission', PermissionController::class);
    Route::resource('/karyawan', KaryawanController::class);
    Route::get('/gaji/{id}/delete', [GajiController::class, 'destroy'])->name('gaji.delete');
    Route::resource('/gaji', GajiController::class);
    Route::get('/thr/{id}/delete', [TunjanganHariRayaController::class, 'destroy'])->name('thr.delete');
    Route::resource('/thr', TunjanganHariRayaController::class);
    Route::get('/kasbon/{id}/delete', [KasbonController::class, 'destroy'])->name('kasbon.delete');
    Route::resource('/kasbon', KasbonController::class);
    Route::get('/reimburse/delete/attachment/{id}', [ReimburseController::class, 'deleteAttachment'])->name('reimburse.delete-attachment');
    Route::get('/reimburse/{id}/delete', [ReimburseController::class, 'destroy'])->name('reimburse.delete');
    Route::resource('/reimburse', ReimburseController::class);
    Route::get('/project/{id}/delete', [ProjectController::class, 'destroy'])->name('project.delete');
    Route::resource('/project', ProjectController::class);
    Route::get('/price-submit/{id}/delete', [PriceSubmitController::class, 'destroy'])->name('price-submit.delete');
    Route::resource('/price-submit', PriceSubmitController::class);
    Route::get('/price-developer/{id}/delete', [PriceDeveloperController::class, 'destroy'])->name('price-developer.delete');
    Route::resource('/price-developer', PriceDeveloperController::class);
    Route::get('/paid-project/{id}/delete', [PaidProjectController::class, 'destroy'])->name('paid-project.delete');
    Route::resource('/paid-project', PaidProjectController::class);
    Route::get('/paid-developer/delete/attachment/{id}', [PaidDeveloperController::class, 'deleteAttachment'])->name('paid-developer.delete-attachment');
    Route::get('/paid-developer/{id}/delete', [PaidDeveloperController::class, 'destroy'])->name('paid-developer.delete');
    Route::resource('/paid-developer', PaidDeveloperController::class);
});
