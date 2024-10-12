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
    return view('LandingPage.home');
});
Route::get('/layanan', function () {
    return view('LandingPage.layanan');
});
Route::get('/dokumentasi', function () {
    return view('LandingPage.dokumentasi');
});
Route::get('/FAQ', function () {
    return view('LandingPage.FAQ');
});
Route::get('/tentangDawala', function () {
    return view('LandingPage.tentangDawala');
});
Route::get('/timDawala', function () {
    return view('LandingPage.timDawala');
});
