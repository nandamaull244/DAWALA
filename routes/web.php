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

Route::get('/service/cekNIK', [AuthController::class, 'cekNIK'])->name('pelayanan.cekNIK');

//  ADMIN ROUTES GROUP -->
Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'checkRole:admin'], 'as' => 'admin.'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('/pelayanan', MainServiceController::class);  
    Route::get('/service/data', [MainServiceController::class, 'getData'])->name('pelayanan.data');
    Route::patch('/service/working-status/{id}', [MainServiceController::class, 'workingStatus'])->name('pelayanan.working-status');
    Route::post('/service/export/excel', [MainServiceController::class, 'exportExcel'])->name('pelayanan.export.excel');
    Route::post('/service/export/pdf', [MainServiceController::class, 'exportPDF'])->name('pelayanan.export.pdf');

    // ARTICLES -->
    Route::resource('/article', ArticleController::class);
    Route::get('/articles/data', [ArticleController::class, 'getData'])->name('article.data');

    Route::get('/manajemen-akun/verification', [UserController::class, 'verification'])->name('manajemen-akun.verification');
    Route::get('/manajemen-akun/create-operator', [UserController::class, 'createOperator'])->name('manajemen-akun.createOperator');
    Route::post('/manajemen-akun/create-operator/process', [UserController::class, 'storeOperator'])->name('manajemen-akun.storeOperator');
    Route::resource('/manajemen-akun', UserController::class);
    Route::get('/users/getData', [UserController::class, 'getData'])->name('user.data'); 
   
    // Verification routes
    Route::get('/verification', [UserController::class, 'verification'])->name('user.verification');
    Route::get('/verification/data', [UserController::class, 'getVerificationData'])->name('verification.data');
    Route::post('/verification/approve/{id}', [UserController::class, 'approveUser'])->name('verification.approve');
    Route::post('/verification/reject/{id}', [UserController::class, 'rejectUser'])->name('verification.reject');

    // Ubah route untuk mengarah ke UserController
    Route::post('/check-district-availability', [UserController::class, 'checkDistrictAvailability'])
        ->name('check-district-availability');

    Route::get('/check-all-districts-availability', [UserController::class, 'checkAllAvailability'])
        ->name('check-all-districts-availability');
});


//  OPERATOR ROUTES GROUP -->
Route::group(['prefix' => 'operator', 'middleware' => ['auth:admin', 'checkRole:operator'], 'as' => 'operator.'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/articles/data', [ArticleController::class, 'getData'])->name('article.data');

    Route::resource('/pelayanan', MainServiceController::class);  
    Route::get('/service/data', [MainServiceController::class, 'getData'])->name('pelayanan.data');
    Route::get('/service/cekNIK', [MainServiceController::class, 'cekNIK'])->name('pelayanan.cekNIK');
    Route::patch('/service/working-status/{id}', [MainServiceController::class, 'workingStatus'])->name('pelayanan.working-status');

    Route::post('/service/export/excel', [MainServiceController::class, 'exportExcel'])->name('pelayanan.export.excel');
    Route::post('/service/export/pdf', [MainServiceController::class, 'exportPDF'])->name('pelayanan.export.pdf');

    Route::get('/manajemen-akun/verification', [UserController::class, 'verification'])->name('manajemen-akun.verification');
    Route::resource('/manajemen-akun', UserController::class);

     Route::get('/verification', [UserController::class, 'verification'])->name('user.verification');
    Route::get('/verification/data', [UserController::class, 'getVerificationData'])->name('user.verification.data');
    Route::post('/verification/{user}/approve', [UserController::class, 'approveUser'])->name('user.verification.approve');
    Route::post('/verification/{user}/reject', [UserController::class, 'rejectUser'])->name('user.verification.reject');
});


//  instance ROUTES GROUP -->
Route::group(['prefix' => 'instance', 'middleware' => ['auth:client', 'checkRole:instance'], 'as' => 'instance.'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/pelayanan', MainServiceController::class);  
    Route::get('/service/data', [MainServiceController::class, 'getData'])->name('pelayanan.data');
    Route::get('/service/cekNIK', [MainServiceController::class, 'cekNIK'])->name('pelayanan.cekNIK');
});


//  USER ROUTES GROUP -->
Route::group(['prefix' => 'user', 'middleware' => ['auth:user', 'checkRole:user'], 'as' => 'user.'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/pelayanan', MainServiceController::class);  
    Route::get('/service/data', [MainServiceController::class, 'getData'])->name('pelayanan.data');
    Route::get('/service/cekNIK', [MainServiceController::class, 'cekNIK'])->name('pelayanan.cekNIK');
});


// LOCATION ROUTES GROUP -->
Route::get('/get-villages-by-district/{districtId}', [LocationController::class, 'getVillagesByDistrict'])->name('get-villages');


Route::get('/login', function () {
    return redirect('auth/login');
})->name('login');

// AUTHENTICATION ROUTES GROUP -->
Route::group(['prefix' => 'auth'], function () {
    // Public auth routes
    Route::get('/login', [AuthController::class, 'login'])->name('login.index');
    Route::post('/login-user/process', [AuthController::class, 'loginUserProcess'])->name('login-user.process');
    Route::post('/login-admin/process', [AuthController::class, 'loginAdminProcess'])->name('login-admin.process');
    // Route::get('/login-admin', [AuthController::class, 'loginAdmin'])->name('login-admin.index');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.index');
    Route::post('/forgot-password/process', [AuthController::class, 'forgotProcess'])->name('forgot-password.process');
    Route::get('/register', [AuthController::class, 'register'])->name('register.index');
    Route::post('/register/process', [AuthController::class, 'registerProcess'])->name('register.process');
    Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('check-email');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

