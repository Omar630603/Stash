<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\DeliveryVehicleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\DeliveryVehicle;
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

Auth::routes();
Route::get('/', [WelcomeController::class, 'welcome']);
Route::get('/services', [WelcomeController::class, 'services'])->name('welcome.services');
Route::get('/contactUs', [WelcomeController::class, 'contactUs'])->name('welcome.contactus');
Route::get('/aboutUs', [WelcomeController::class, 'aboutUs'])->name('welcome.aboutus');
Route::get('/home', [HomeController::class, 'index'])->name('home');

//UserAccess//Home
Route::get('/customer/home', [UserController::class, 'index'])->name('customer.home')->middleware('UserAccess');
Route::post('/customer/editBioData/{customer}', [UserController::class, 'editCustomer'])->name('customer.editBioData')->middleware('UserAccess');
Route::put('/customer/editImage/{customer}', [UserController::class, 'editCustomerImage'])->name('customer.editImage')->middleware('UserAccess');
Route::post('/customer/defaultImage/{customer}', [UserController::class, 'editCustomerImageDefult'])->name('customer.defaultImage')->middleware('UserAccess');

//BranchAccess//Home
Route::get('/branch/home', [BranchController::class, 'index'])->name('branch.home')->middleware('BranchAccess');
Route::post('/branch/editBioData/{branchEmployee}', [BranchController::class, 'editBranchEmployee'])->name('branch.editBioData')->middleware('BranchAccess');
Route::put('/branch/editImage/{branchEmployee}', [BranchController::class, 'editBranchEmployeeImage'])->name('branch.editImage')->middleware('BranchAccess');
Route::post('/branch/defaultImage/{branchEmployee}', [BranchController::class, 'editBranchEmployeeImageDefult'])->name('branch.defaultImage')->middleware('BranchAccess');
Route::post('/branch/editBranch/{branch}', [BranchController::class, 'editBranch'])->name('branch.editBranch')->middleware('BranchAccess');

//BranchAccess//Categories
Route::get('/branch/categories', [BranchController::class, 'showCategories'])->name('branch.category')->middleware('BranchAccess');
Route::post('/branch/categories/addUnit', [BranchController::class, 'addUnit'])->name('branch.addUnit')->middleware('BranchAccess');
Route::delete('/branch/categories/DeleteUnit/{unit}', [BranchController::class, 'deleteUnit'])->name('branch.deleteUnit')->middleware('BranchAccess');
Route::post('/branch/categories/changePrivateKeyUnit/{unit}', [BranchController::class, 'changePrivateKeyUnit'])->name('branch.changePrivateKeyUnit')->middleware('BranchAccess');
Route::get('/branch/order/detailsU/{unit}', [BranchController::class, 'branchOrderDetailsU'])->name('branch.orderDetailsU')->middleware('BranchAccess');

// //BranchAccess//Delivery&drivers
Route::get('/branch/delivery', [BranchController::class, 'branchDelivery'])->name('branch.delivery')->middleware('BranchAccess');
Route::post('/branch/editBioData/driver/{driver}', [BranchController::class, 'editDriver'])->name('branch.editBioDataDriver')->middleware('BranchAccess');
Route::put('/branch/editImage/driver/{driver}', [BranchController::class, 'editDriverImage'])->name('branch.editImageDriver')->middleware('BranchAccess');
Route::post('/branch/defaultImage/driver/{driver}', [BranchController::class, 'editDriverImageDefult'])->name('branch.defaultImageDriver')->middleware('BranchAccess');
Route::post('/branch/driver/addDriver', [BranchController::class, 'addDriver'])->name('branch.addDriver')->middleware('BranchAccess');
Route::delete('/branch/driver/deleteDriver/{driver}', [BranchController::class, 'deleteDriver'])->name('branch.deleteDriver')->middleware('BranchAccess');
Route::post('/branch/driver/addSchedule', [BranchController::class, 'addSchedule'])->name('branch.addSchedule')->middleware('BranchAccess');
Route::post('/branch/driver/changeScheduleStatus/{schedule}', [BranchController::class, 'changeScheduleStatus'])->name('branch.changeScheduleStatus')->middleware('BranchAccess');
Route::delete('/branch/driver/deleteSchedule/{schedule}', [BranchController::class, 'deleteSchedule'])->name('branch.deleteSchedule')->middleware('BranchAccess');
Route::post('/branch/driver/editSchedule/{schedule}', [BranchController::class, 'editSchedule'])->name('branch.editSchedule')->middleware('BranchAccess');

// //BranchAccess//Orders&Users
Route::get('/branch/orders', [BranchController::class, 'branchOrders'])->name('branch.orders')->middleware('BranchAccess');
Route::delete('/branch/branchAccess/deleteOrder/{order}', [BranchController::class, 'deleteOrder'])->name('branch.deleteOrder')->middleware('BranchAccess');
Route::post('/branch/editBioData/user/{user}', [BranchController::class, 'editUser'])->name('branch.editBioDataUser')->middleware('BranchAccess');
Route::put('/branch/editImage/user/{user}', [BranchController::class, 'editUserImage'])->name('branch.editImageUser')->middleware('BranchAccess');
Route::post('/branch/defaultImage/user/{user}', [BranchController::class, 'editUserImageDefultCustomer'])->name('branch.defaultImageUser')->middleware('BranchAccess');
Route::post('/branch/user/addUser', [BranchController::class, 'addUser'])->name('branch.addUser')->middleware('BranchAccess');
Route::delete('/branch/user/deleteUser/{user}', [BranchController::class, 'deleteUser'])->name('branch.deleteUser')->middleware('BranchAccess');
Route::post('/branch/user/addOrder', [BranchController::class, 'addOrder'])->name('branch.addOrder')->middleware('BranchAccess');
Route::get('/branch/order/details/{order}', [BranchController::class, 'branchOrderDetails'])->name('branch.orderDetails')->middleware('BranchAccess');
Route::post('/branch/branchAccess/extendOrder/{order}', [BranchController::class, 'extendOrder'])->name('branch.extendOrder')->middleware('BranchAccess');
Route::post('/branch/branchAccess/changeOrderStatus/{order}', [BranchController::class, 'changeOrderStatus'])->name('branch.changeOrderStatus')->middleware('BranchAccess');
Route::post('/branch/branchAccess/changeOrderDescription/{order}', [BranchController::class, 'changeOrderDescription'])->name('branch.changeOrderDescription')->middleware('BranchAccess');
Route::post('/branch/unit/order/changeUnitCapacity/{unit}', [BranchController::class, 'changeUnitCapacity'])->name('branch.changeUnitCapacity')->middleware('BranchAccess');
Route::post('/branch/unit/order/changeOrderUnit/{unit}/{order}', [BranchController::class, 'changeOrderUnit'])->name('branch.changeOrderUnit')->middleware('BranchAccess');
Route::post('/branch/branchAccess/order/payTransaction/{transaction}', [BranchController::class, 'payTransaction'])->name('branch.payTransaction')->middleware('BranchAccess');
Route::get('/branch/branchAccess/order/approveTransaction/{transaction}', [BranchController::class, 'approveTransaction'])->name('branch.approveTransaction')->middleware('BranchAccess');
Route::get('/branch/branchAccess/order/disapproveTransaction/{transaction}', [BranchController::class, 'disapproveTransaction'])->name('branch.disapproveTransaction')->middleware('BranchAccess');
Route::post('/branch/branchAccess/order/deleteTransaction/{transaction}', [BranchController::class, 'deleteTransaction'])->name('branch.deleteTransaction')->middleware('BranchAccess');

//Branch bank routes
Route::post('/branch/AddBank', [BranchController::class, 'addBank'])->name('branch.addBank')->middleware('BranchAccess');
Route::post('/branch/editBranchBank/{bank}', [BranchController::class, 'editBranchBank'])->name('branch.editBranchBank')->middleware('BranchAccess');
Route::delete('/branch/deleteBank/{bank}', [BranchController::class, 'deleteBank'])->name('branch.deleteBank')->middleware('BranchAccess');
Route::get('/branch/Transactions', [BranchController::class, 'branchTransactions'])->name('branch.transactions')->middleware('BranchAccess');

//Driver Access
Route::get('/driver/home', [DeliveryVehicleController::class, 'index'])->name('driver.home')->middleware('DriverAccess');
Route::post('/driver/editBioData/driver/{driver}', [DeliveryVehicleController::class, 'editDriver'])->name('driver.editBioDataDriver')->middleware('DriverAccess');
Route::put('/driver/editImage/driver/{driver}', [DeliveryVehicleController::class, 'editDriverImage'])->name('driver.editImageDriver')->middleware('DriverAccess');
Route::post('/driver/defaultImage/driver/{driver}', [DeliveryVehicleController::class, 'editDriverImageDefult'])->name('driver.defaultImageDriver')->middleware('DriverAccess');
Route::delete('/driver/driver/deleteDriver/{driver}', [DeliveryVehicleController::class, 'deleteDriver'])->name('driver.deleteDriver')->middleware('DriverAccess');

Auth::routes();
