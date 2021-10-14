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

//AdminAccess//Home
Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.home')->middleware('AdminAccess');
Route::post('/admin/editBioData/{admin}', [AdminController::class, 'editAdmin'])->name('admin.editBioData')->middleware('AdminAccess');
Route::put('/admin/editImage/{admin}', [AdminController::class, 'editAdminImage'])->name('admin.editImage')->middleware('AdminAccess');
Route::post('/admin/defaultImage/{admin}', [AdminController::class, 'editUserImageDefult'])->name('admin.defaultImage')->middleware('AdminAccess');
Route::post('/admin/editBranch/{branch}', [AdminController::class, 'editBranch'])->name('admin.editBranch')->middleware('AdminAccess');
//AdminAccess//Categories
Route::get('/admin/categories', [AdminController::class, 'showCategories'])->name('admin.category')->middleware('AdminAccess');
Route::post('/admin/categories/addUnit', [AdminController::class, 'addUnit'])->name('admin.addUnit')->middleware('AdminAccess');
Route::delete('/admin/categories/DeleteUnit/{unit}', [AdminController::class, 'deleteUnit'])->name('admin.deleteUnit')->middleware('AdminAccess');
Route::post('/admin/categories/changePrivateKeyUnit/{unit}', [AdminController::class, 'changePrivateKeyUnit'])->name('admin.changePrivateKeyUnit')->middleware('AdminAccess');
Route::post('/admin/categories/changeUnitStatus/{unit}', [AdminController::class, 'changeUnitStatus'])->name('admin.changeUnitStatus')->middleware('AdminAccess');
//AdminAccess//Delivery&drivers
Route::get('/admin/delivery', [AdminController::class, 'adminDelivery'])->name('admin.delivery')->middleware('AdminAccess');
Route::post('/admin/editBioData/driver/{driver}', [AdminController::class, 'editDriver'])->name('admin.editBioDataDriver')->middleware('AdminAccess');
Route::put('/admin/editImage/driver/{driver}', [AdminController::class, 'editDriverImage'])->name('admin.editImageDriver')->middleware('AdminAccess');
Route::post('/admin/defaultImage/driver/{driver}', [AdminController::class, 'editDriverImageDefult'])->name('admin.defaultImageDriver')->middleware('AdminAccess');
Route::post('/admin/driver/addDriver', [AdminController::class, 'addDriver'])->name('admin.addDriver')->middleware('AdminAccess');
Route::delete('/admin/driver/deleteDriver/{driver}', [AdminController::class, 'deleteDriver'])->name('admin.deleteDriver')->middleware('AdminAccess');
Route::post('/admin/driver/addSchedule', [AdminController::class, 'addSchedule'])->name('admin.addSchedule')->middleware('AdminAccess');
Route::post('/admin/driver/changeScheduleStatus/{schedule}', [AdminController::class, 'changeScheduleStatus'])->name('admin.changeScheduleStatus')->middleware('AdminAccess');
Route::delete('/admin/driver/deleteSchedule/{schedule}', [AdminController::class, 'deleteSchedule'])->name('admin.deleteSchedule')->middleware('AdminAccess');
Route::post('/admin/driver/editSchedule/{schedule}', [AdminController::class, 'editSchedule'])->name('admin.editSchedule')->middleware('AdminAccess');

//AdminAccess//Orders&Users
Route::get('/admin/orders', [AdminController::class, 'adminOrders'])->name('admin.orders')->middleware('AdminAccess');
Route::delete('/admin/driver/deleteOrder/{order}', [AdminController::class, 'deleteOrder'])->name('admin.deleteOrder')->middleware('AdminAccess');
Route::post('/admin/driver/extendOrder/{order}', [AdminController::class, 'extendOrder'])->name('admin.extendOrder')->middleware('AdminAccess');
Route::post('/admin/editBioData/user/{user}', [AdminController::class, 'editUser'])->name('admin.editBioDataUser')->middleware('AdminAccess');
Route::put('/admin/editImage/user/{user}', [AdminController::class, 'editUserImage'])->name('admin.editImageUser')->middleware('AdminAccess');
Route::post('/admin/defaultImage/user/{user}', [AdminController::class, 'editUserImageDefultCustomer'])->name('admin.defaultImageUser')->middleware('AdminAccess');
Route::post('/admin/user/addUser', [AdminController::class, 'addUser'])->name('admin.addUser')->middleware('AdminAccess');
Route::delete('/admin/user/deleteUser/{user}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser')->middleware('AdminAccess');
Route::post('/admin/user/addOrder', [AdminController::class, 'addOrder'])->name('admin.addOrder')->middleware('AdminAccess');
Route::get('/admin/order/detailsU/{unit}', [AdminController::class, 'adminOrderDetailsU'])->name('admin.orderDetailsU')->middleware('AdminAccess');
Route::get('/admin/order/details/{order}', [AdminController::class, 'adminOrderDetails'])->name('admin.orderDetails')->middleware('AdminAccess');

Auth::routes();

