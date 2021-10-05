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
Route::post('/admin/editBioData/{admin}', [AdminController::class, 'editAdmin'])->name('admin.editBioData')->middleware('AdminAccess');
Route::put('/admin/editImage/{admin}', [AdminController::class, 'editAdminImage'])->name('admin.editImage')->middleware('AdminAccess');
Route::post('/admin/defaultImage/{admin}', [AdminController::class, 'editUserImageDefult'])->name('admin.defaultImage')->middleware('AdminAccess');
Route::post('/admin/editBranch/{branch}', [AdminController::class, 'editBranch'])->name('admin.editBranch')->middleware('AdminAccess');
Route::get('/admin/categories', [AdminController::class, 'showCategories'])->name('admin.category')->middleware('AdminAccess');
Route::post('/admin/categories/addUnit', [AdminController::class, 'addUnit'])->name('admin.addUnit')->middleware('AdminAccess');
Route::delete('/admin/categories/DeleteUnit/{unit}', [AdminController::class, 'deleteUnit'])->name('admin.deleteUnit')->middleware('AdminAccess');
Route::post('/admin/categories/changePrivateKeyUnit/{unit}', [AdminController::class, 'changePrivateKeyUnit'])->name('admin.changePrivateKeyUnit')->middleware('AdminAccess');

Auth::routes();

