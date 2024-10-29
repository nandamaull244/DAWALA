<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Backend\KKController;
use App\Http\Controllers\Backend\KTPController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MainServiceController;
use App\Http\Controllers\Backend\ArticleController;
use App\Http\Controllers\Backend\FormArticleController;
use App\Http\Controllers\Backend\UserController;

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
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin', 'as' => 'admin.'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('/pelayanan', MainServiceController::class);  
    Route::get('/service/data', [MainServiceController::class, 'getData'])->name('pelayanan.data');
    Route::post('/service/export/excel', [MainServiceController::class, 'exportExcel'])->name('pelayanan.export.excel');
    Route::post('/service/export/pdf', [MainServiceController::class, 'exportPDF'])->name('pelayanan.export.pdf');

    // ARTICLES -->
    Route::resource('/article', ArticleController::class);
    Route::get('/articles/data', [ArticleController::class, 'getData'])->name('article.data');

    Route::get('/manajemen-akun/verification', [UserController::class, 'verification'])->name('manajemen-akun.verification');
    Route::resource('/manajemen-akun', UserController::class);
    Route::get('/users/getData', [UserController::class, 'getData'])->name('user.data'); 
   
    // Verification routes
    Route::get('/verification', [UserController::class, 'verificationTable'])->name('admin.user.verification');
    Route::get('/verification/data', [UserController::class, 'getVerificationData'])->name('admin.user.verification.data');
    Route::post('/verification/{user}/approve', [UserController::class, 'approveUser'])->name('admin.user.verification.approve');
    Route::post('/verification/{user}/reject', [UserController::class, 'rejectUser'])->name('admin.user.verification.reject');
});


//  OPERATOR ROUTES GROUP -->
Route::group(['prefix' => 'operator', 'middleware' => 'auth:operator', 'as' => 'operator.'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/articles/data', [ArticleController::class, 'getData'])->name('article.data');


    Route::resource('/pelayanan', MainServiceController::class);  
    Route::get('/service/data', [MainServiceController::class, 'getData'])->name('pelayanan.data');
    Route::post('/service/export/excel', [MainServiceController::class, 'exportExcel'])->name('pelayanan.export.excel');
    Route::post('/service/export/pdf', [MainServiceController::class, 'exportPDF'])->name('pelayanan.export.pdf');
});


//  instance ROUTES GROUP -->
Route::group(['prefix' => 'instance', 'middleware' => 'auth:instance', 'as' => 'instance.'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/pelayanan', MainServiceController::class);  
    Route::get('/service/data', [MainServiceController::class, 'getData'])->name('pelayanan.data');
});


//  USER ROUTES GROUP -->
Route::group(['prefix' => 'user', 'middleware' => 'auth:user', 'as' => 'user.'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/pelayanan', MainServiceController::class);  
    Route::get('/service/data', [MainServiceController::class, 'getData'])->name('pelayanan.data');
});


// LOCATION ROUTES GROUP -->
Route::get('/get-villages-by-district/{districtId}', [LocationController::class, 'getVillagesByDistrict'])->name('get-villages');


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
    Route::get('/', [PageController::class, 'home'])->name('page.home');
    Route::get('/layanan', [PageController::class, 'service'])->name('page.service');
    Route::get('/layanan-cepat', [PageController::class, 'fastService'])->name('page.fast-service');
    Route::get('/dokumentasi', [PageController::class, 'documentation'])->name('page.documentation');
    Route::get('/dokumentasi/{article}', [PageController::class, 'documentationDetail'])->name('page.documentation.detail');
    Route::get('/FAQ', [PageController::class, 'FAQ'])->name('page.FAQ');
    Route::get('/tentang-dawala', [PageController::class, 'about'])->name('page.about');
    Route::get('/tim-dawala', [PageController::class, 'dawalaTeam'])->name('page.tim-dawala');
    Route::get('/visi-misi', [PageController::class, 'visiMisi'])->name('page.visimisi');
    Route::get('/detail-persyaratan', [PageController::class, 'detailPersyaratan'])->name('page.detail-persyaratan');
});

