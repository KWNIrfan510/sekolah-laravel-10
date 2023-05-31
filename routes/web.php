<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['register' => false]);

Route::prefix('admin')->group(function () {
    Route::group(['middleware' => 'auth'], function() {
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard.index');
        
        // Permissions
        Route::resource('/permission', App\Http\Controllers\Admin\PermissionController::class, ['except' => ['show','create','edit','update','delete'], 'as' => 'Admin']);
    });
});