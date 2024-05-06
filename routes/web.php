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
    Route::group(['middleware' => 'auth'], function () {
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard.index');

        // Permissions
        Route::resource('/permission', App\Http\Controllers\Admin\PermissionController::class, ['except' => ['show', 'create', 'edit', 'update', 'delete'], 'as' => 'Admin']);

        // Roles
        Route::resource('/role', App\Http\Controllers\Admin\RoleController::class, ['except' => ['show'], 'as' => 'admin']);

        // Users
        Route::resource('/user', App\Http\Controllers\Admin\UserController::class, ['except' => ['show'], 'as' => 'admin']);

        // Tags
        Route::resource('/tag', App\Http\Controllers\Admin\TagController::class, ['except' => ['show'], 'as' => 'admin']);

        // Category
        Route::resource('/category', App\Http\Controllers\Admin\CategoryController::class, ['except' => ['show'], 'as' => 'admin']);

        // Post
        Route::resource('/post', App\Http\Controllers\Admin\PostController::class, ['except' => ['show'], 'as' => 'admin']);

        // Event
        Route::resource('/event', App\Http\Controllers\Admin\EventController::class, ['except' => ['show'], 'as' => 'admin']);

        // Photo
        Route::resource('/photo', App\Http\Controllers\Admin\PhotoController::class, ['except' => ['show', 'create', 'edit', 'update'], 'as' => 'admin']);
    });
});

Route::get('/test', function () {
    return "test";
});
