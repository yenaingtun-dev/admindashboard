<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;

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

Route::redirect('/', '/login');

Auth::routes();

Route::group(
      ['prefix' => 'admin',  'middleware' => ['auth']],
      function () {
            Route::get('/home', [HomeController::class, 'index'])->name('home');
            Route::resource('/users', UserController::class);
            Route::post('/users/storeMedia', [UserController::class, 'storeMedia'])->name('users.store_media');
            Route::post('/users/removeMedia', [UserController::class, 'removeMedia'])->name('users.remove_media');
            Route::resource('/roles', RoleController::class);
            Route::resource('/branches', BranchController::class);
            Route::resource('/permissions', PermissionController::class);
      }
);
