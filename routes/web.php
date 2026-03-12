<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
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

Route::get('/admin-register', [AuthController::class, 'showRegister'])->name('admin.register');
Route::post('/admin-register', [AuthController::class, 'register'])->name('admin.register.store');

Route::get('/admin-login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::get('/', [AuthController::class, 'showLogin'])->name('admin.login');

Route::post('/admin-login', [AuthController::class, 'login'])->name('admin.login.check');

Route::post('/admin-logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/blogs',[BlogController::class,'index'])->name('blogs.index');

    Route::post('/blogs',[BlogController::class,'store'])->name('blogs.store');

    Route::put('/blogs/{id}',[BlogController::class,'update'])->name('blogs.update');

    Route::delete('/blogs/{id}',[BlogController::class,'destroy'])->name('blogs.destroy');
      

});

