<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;

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

// Auth::routes();
Route::get('/', function () {
  return view('welcome');
});

// Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function () {
//   Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth:admin');
// });

// Route::group(['namespace' => 'Admin', 'middleware' => ['auth:user'], 'prefix' => '/admin'], function () {
//   Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.home');
// });
// Route::group(['namespace' => 'Admin', 'middleware' => ['auth:user'], 'prefix' => '/admin'], function () {
//   Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.home');
// });

Route::middleware(['auth:user'])->group(function () {
  Route::get('/user/dashboard', [AdminController::class, 'index'])->name('user.dashboard');
});

Route::namespace('Auth')->group(function () {
  //Login Routes
  Route::get('/user/login', [LoginController::class, 'showLoginForm'])->name('user.login');
  Route::post('/user/login', [LoginController::class, 'userLogin'])->name('user.login');
  Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

  // Register Routes
  Route::get('/user/register', [RegisterController::class, 'showRegisterForm'])->name('user.register');
  Route::post('/user/register', [RegisterController::class, 'register'])->name('user.register');

  //Forgot Password Routes
  Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
  Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

  //Reset Password Routes
  Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
  Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.update');

  Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');

});
Route::get('/home', [AdminController::class, 'index'])->name('home');
