<?php

use Illuminate\Support\Facades\Route;
use Idev\EasyAdmin\app\Http\Controllers\RoleController;
use Idev\EasyAdmin\app\Http\Controllers\UserController;
use Idev\EasyAdmin\app\Http\Controllers\AuthController;
use Idev\EasyAdmin\app\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\ProductsController;

/*
Route::get('/', function () {
    return view('welcome');
});
*/



Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::get('cek', [AuthController::class, 'cek']);

/*
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');
*/

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('role', RoleController::class);
    Route::get('role-api', [RoleController::class, 'indexApi'])->name('role.listapi');
    Route::get('role-export-pdf-default', [RoleController::class, 'exportPdf'])->name('role.export-pdf-default');
    Route::get('role-export-excel-default', [RoleController::class, 'exportExcel'])->name('role.export-excel-default');
    Route::post('role-import-excel-default', [RoleController::class, 'importExcel'])->name('role.import-excel-default');

    Route::resource('transactions', TransactionsController::class);
    //Route::get('transactions', [TransactionsController::class, 'index']);
    Route::get('transactions-api', [TransactionsController::class, 'indexApi'])->name('transactions.listapi');
    Route::get('transactions-export-pdf-default', [TransactionsController::class, 'exportPdf'])->name('transactions.export-pdf-default');
    Route::get('transactions-export-excel-default', [TransactionsController::class, 'exportExcel'])->name('transactions.export-excel-default');
    Route::post('transactions-import-excel-default', [TransactionsController::class, 'importExcel'])->name('transactions.import-excel-default');

    Route::resource('products', ProductsController::class);
    Route::get('products-api', [ProductsController::class, 'indexApi'])->name('products.listapi');
    Route::get('products-export-pdf-default', [ProductsController::class, 'exportPdf'])->name('products.export-pdf-default');
    Route::get('products-export-excel-default', [ProductsController::class, 'exportExcel'])->name('products.export-excel-default');
    Route::post('products-import-excel-default', [ProductsController::class, 'importExcel'])->name('products.import-excel-default');

    Route::resource('user', UserController::class);
    Route::get('user-api', [UserController::class, 'indexApi'])->name('user.listapi');
    Route::get('user-export-pdf-default', [UserController::class, 'exportPdf'])->name('user.export-pdf-default');
    Route::get('user-export-excel-default', [UserController::class, 'exportExcel'])->name('user.export-excel-default');
    Route::post('user-import-excel-default', [UserController::class, 'importExcel'])->name('user.import-excel-default');

    Route::get('logout', [AuthController::class, 'logout'])->name("logout");
  
    Route::get('my-account', [UserController::class, 'profile']);
    Route::post('update-profile', [UserController::class, 'updateProfile']);
});


