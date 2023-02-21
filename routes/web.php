<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\HomeController;

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

Route::group(['namespace' => 'Admin', 'middleware' => ['auth:admin'], 'prefix' => '/admin'], function () {
  Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.home');
});

Route::namespace('Auth')->group(function () {

  //Login Routes
  Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/admin/login', [LoginController::class, 'login'])->name('login');
  Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

  // Register Routes
  Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
  Route::post('/register', [RegisterController::class, 'register'])->name('register');

  //Forgot Password Routes
  Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
  Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

  //Reset Password Routes
  Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
  Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.update');
});
// \app\Http\Middleware\RedirectIfAuthenticated.php

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
