<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MobileController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\production\DashboardController as ProductionDashboard;
use App\Http\Controllers\qc\DashboardController as QcDashboard;
use App\Http\Controllers\production\ProductionInsert;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\ReceiverController;
use App\Http\Controllers\admin\ProductionController;
use App\Http\Controllers\admin\QcController;
use App\Http\Controllers\admin\DeliveryController;
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

Route::get('/storage-link', function () { 
    $targetFolder = base_path().'/storage/app/public'; 
    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage'; 
    symlink($targetFolder, $linkFolder); 
});

Route::get('/clear-cache', function () {
    Artisan::call('route:cache');
});

Route::get('/', [LoginController::class, 'index']);

// Authentication
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/m/login', [MobileController::class, 'login']);
Route::post('/m/login', [MobileController::class, 'auth'])->name('m.login');
Route::post('/m/logout', [MobileController::class, 'logout'])->name('m.logout');

//Admin
Route::prefix('admin')
->middleware('auth','admin')
->group(function(){
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('admin-dashboard');
    Route::resource('/user',UserController::class);
    Route::resource('/project',ProjectController::class);

    Route::resource('/receiver',ReceiverController::class);
    Route::get('/receiver/history/{id}',[ReceiverController::class,'history_stock'])->name('receiver.history');
    Route::post('receiver/ajukan',[ReceiverController::class,'ajukan'])->name('receiver.ajukan');

    Route::resource('/production',ProductionController::class);
    Route::post('production/ajukan',[ProductionController::class,'ajukan'])->name('production.ajukan');
    Route::get('/production/history/{id}',[ProductionController::class,'history_stock'])->name('production.history');

    Route::resource('/qc',QcController::class);
    Route::get('/qc/history/{id}',[QcController::class,'history_stock'])->name('qc.history');
    
    Route::resource('/delivery',DeliveryController::class);
});

Route::prefix('production')
->group(function(){
    Route::get('/',[ProductionDashboard::class,'index'])->name('production.dashboard');
    Route::get('/dashboard',[ProductionDashboard::class,'index'])->name('production.dashboard');
    Route::get('/insert',[ProductionInsert::class,'index'])->name('production.insert');
    Route::post('/insert/{id}',[ProductionInsert::class,'store'])->name('production.store');
});

Route::prefix('qc')
->group(function(){
    Route::get('/',[QcDashboard::class,'index'])->name('qc.dashboard');
    Route::get('/dashboard',[QcDashboard::class,'index'])->name('qc.dashboard');
});

Route::prefix('m')
->middleware('non-admin')
->group(function(){
    Route::get('/', [MobileController::class, 'index'])->name('m');
    Route::post('/accept/{id}', [MobileController::class, 'accept'])->name('m.accept');
    
    Route::middleware('production-middleware')->group(function () {
        Route::get('/production/{id}', [MobileController::class, 'production'])->name('m.production');
        Route::post('/production/ajukan/{id}', [MobileController::class, 'ajukan_production'])->name('m.production.ajukan');
    });

    Route::middleware('qc-middleware')->group(function () {
        Route::get('/qc/{id}', [MobileController::class, 'qc'])->name('m.qc');
        Route::post('/qc/ajukan_ncp/{id}', [MobileController::class, 'ajukan_ncp'])->name('m.qc.ajukan_ncp');
        Route::post('/qc/ajukan_fg/{id}', [MobileController::class, 'ajukan_fg'])->name('m.qc.ajukan_fg');
        Route::post('/qc/ajukan_repair/{id}', [MobileController::class, 'ajukan_repair'])->name('m.qc.ajukan_repair');
    });

    Route::middleware(['delivery-middleware'])->group(function () {
        Route::get('/surat_jalan', [MobileController::class, 'surat_jalan'])->name('m.surat_jalan');
        Route::post('/surat_jalan', [MobileController::class, 'unduh_surat_jalan'])->name('m.surat_jalan');
        Route::prefix('delivery')->group(function () {
            Route::get('/{id}', [MobileController::class, 'delivery'])->name('m.delivery');
            Route::post('/masukan/{id}', [MobileController::class, 'masukan'])->name('m.delivery.masukan');
        });
    });
});
