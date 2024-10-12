<?php

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