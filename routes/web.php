<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FormKtpController;
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

//  ADMIN ROUTES GROUP -->
Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

//  ADMIN ROUTES GROUP -->
Route::group(['prefix' => 'operator', 'middleware' => ['auth:operator']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('operator.dashboard');
});

//  INSTANTIATION ROUTES GROUP -->
Route::group(['prefix' => 'instantiation', 'middleware' => ['auth:instantiation']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('instantiation.dashboard');
});

//  USER ROUTES GROUP -->
Route::group(['prefix' => 'user', 'middleware' => ['auth:user']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
});

// AUTHENTICATION ROUTES GROUP -->
Route::group(['prefix' => 'auth'], function () {
    // Public auth routes
    Route::get('/login', [AuthController::class, 'login'])->name('login.index');
    Route::post('/login/process', [AuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/login-admin', [AuthController::class, 'loginAdmin'])->name('login-admin.index');
    Route::post('/login-admin/process', [AuthController::class, 'loginAdminProcess'])->name('login-admin.process');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.index');
    Route::post('/forgot-password/process', [AuthController::class, 'forgotProcess'])->name('forgot-password.process');
    Route::get('/register', [AuthController::class, 'register'])->name('register.index');
    Route::post('/register/process', [AuthController::class, 'registerProcess'])->name('register.process');
    Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('check-email');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');

    // Protected auth routes
    Route::group(['middleware' => 'auth'], function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    // Admin-specific auth routes
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::post('/logout-admin', [AuthController::class, 'logoutAdmin'])->name('logout-admin');
    });
});


// MAIN PAGE ROUTES GROUP -->
Route::group([], function () {
    Route::get('/', function () {
        return view('LandingPage.pages.home');
    });
    
    Route::get('/layanan', function () {
        return view('LandingPage.pages.layanan');
    });
    
    Route::get('/dokumentasi', function () {
        return view('LandingPage.pages.dokumentasi');
    });
    
    Route::get('/FAQ', function () {
        return view('LandingPage.pages.FAQ');
    });
    
    Route::get('/tentang-dawala', function () {
        return view('LandingPage.pages.tentangDawala');
    });
    
    Route::get('/tim-dawala', function () {
        return view('LandingPage.pages.timDawala');
    });
    
    Route::get('/detail-persyaratan', function () {
        return view('LandingPage.pages.detailPersyaratan');
    });
});
