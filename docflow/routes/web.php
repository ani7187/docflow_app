<?php

use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\PartnerPerson\PartnerPersonController;
use App\Http\Controllers\writing\IndexController;
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

//Route::get('/login', function () {
//    return "aaa";
//});
//

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/', [IndexController::class, '__invoke'])->name('home');

//Route::group(["namespace" => "Writing"], function (){
//    Route::get('/', 'IndexController');
//});

//Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login');

//Auth::routes();

Route::group(['namespace' => 'writing'], function () {
    Route::get('/', [IndexController::class, '__invoke'])->name('writing.index');
});


Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');

    Route::get('/employee', [CompanyController::class, 'show'])->name('employee');
    Route::get('employee/{user}/edit', [PartnerPersonController::class, 'edit'])->name('employee.edit');
    Route::put('employee/{user}', [PartnerPersonController::class, 'update'])->name('employee.update');


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
