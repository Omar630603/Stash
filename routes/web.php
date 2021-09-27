<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//UserAccess//
Route::get('/user/home', [UserController::class, 'index'])->name('user.home')->middleware('UserAccess');
//AdminAccess//
Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.home')->middleware('AdminAccess');
Auth::routes();

