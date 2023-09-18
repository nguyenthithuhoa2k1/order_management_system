<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\PaginationController;
use App\Http\Controllers\orders\OrderController;
use App\Http\Controllers\orders\SearchController;
use App\Http\Controllers\admin\LoginUserController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\Analytics\AnalyticController;
use App\Http\Controllers\customers\CustomerController;
use App\Http\Controllers\import_allocation\ImportAllocationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//login
Route::get('login',[LoginUserController::class,'index'])->name('login');
Route::post('login',[LoginUserController::class,'login']);
//logout
Route::get('logout',[LoginUserController::class,'logout']);
Route::middleware('checkUserLevel')->group(function () {
    //users
    Route::get('list/users',[UserController::class,'index'])->name('users');
    Route::get('edit/users/{id}',[UserController::class,'edit']);
    Route::post('edit/users/{id}',[UserController::class,'update']);
    Route::delete('delete/users/{id}',[UserController::class,'destroy']);
    //product
    Route::resource('products', ProductController::class);
    //register
    Route::get('register/users',[UserController::class,'showFormRegisterUser'])->name('usersRegister');
    Route::post('register/users',[UserController::class,'store']);
});

//client
Route::resource('customers', CustomerController::class);
//orders
Route::resource('orders', OrderController::class);
Route::post('orders/insert',[OrderController::class,'orderInsert']);
//search
Route::GET('search/name',[SearchController::class,'searchProductName']);
Route::GET('search/code',[SearchController::class,'searchProductCode']);
Route::GET('search/customer/name',[SearchController::class,'searchCustomerName']);
Route::GET('search/customer/phone',[SearchController::class,'searchCustomerPhone']);
Route::GET('search/users/userId',[SearchController::class,'searchUserId']);
//import_allocation
Route::get('/important-location', [ImportAllocationController::class, 'index'])->name('important-location');
Route::post('/important-location', [ImportAllocationController::class, 'importantLocation']);
//Analytics
Route::get('/analytics', [AnalyticController::class, 'getDataAnalytics'])->name('analytics');
// Route::get('/analytics/fetch_data', [AnalyticController::class, 'fetch_data']);

// coding
Route::get('/analytics/fetch_data/dataCustomer', [AnalyticController::class, 'fetchDataCustomer']);
Route::get('/analytics/fetch_data/productIdBestseller', [AnalyticController::class, 'fetchDataProductIdBestSeller']);
Route::get('/analytics/fetch_data/dataProduct', [AnalyticController::class, 'fetchDataProduct']);
// end coding

//pagination
Route::get('/pagination', [PaginationController::class, 'pagination']);


Route::view('/unauthorized', 'errors.unauthorized')->name('unauthorized');

