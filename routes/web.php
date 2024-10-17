<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;

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
//dashboard
Route::group(['prefix' => 'admin'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
});

//auth routes

//login user
Route::get('/login', [AuthController::class, 'login'])->name('login.index');
Route::post('/login/process', [AuthController::class, 'loginProcess'])->name('login.process');

//login admin
Route::get('/login-admin', [AuthController::class, 'loginAdmin'])->name('loginAdmin.index');
Route::post('/login-admin/process', [AuthController::class, 'loginAdminProcess'])->name('loginAdmin.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout-admin', [AuthController::class, 'logoutAdmin'])->name('logoutAdmin');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.index');
Route::post('/forgot-password/process', [AuthController::class, 'forgotProcess'])->name('forgot-password.process');
Route::get('/register', [AuthController::class, 'register'])->name('register.index');
Route::post('/register/process', [AuthController::class, 'registerProcess'])->name('register.process');
Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('check-email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');


//dashboard admin
Route::get('/admin/dashboard', [DashboardController::class, 'dashboardAdmin'])->name('dashboardAdmin.dashboardAdmin');
// landing page routes
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

Route::get('/layanan-cepat', function () {
    return view('LandingPage.pages.layananCepat');
});
//end of landing page routes

