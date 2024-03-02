<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\PartnerPerson\PartnerPersonController;
use App\Http\Controllers\Section\SectionController;
use App\Http\Controllers\SectionPermission\SectionPermissionController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserGroup\UserGroupController;
use App\Http\Controllers\UserGroupUser\UserGroupUserController;
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



//Auth::routes();
Auth::routes(['verify' => true]);



Route::group(['namespace' => 'writing', 'middleware' => ['verified', 'auth']], function () {
    Route::get('/', [IndexController::class, '__invoke'])->name('writing.index');
});

Route::middleware(['verified', 'auth'])->group(function () {

    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');

    Route::get('/employee', [CompanyController::class, 'show'])->name('employee');
    Route::get('employee/add', [PartnerPersonController::class, 'add'])->name('employee.add');
    Route::post('employee/store', [PartnerPersonController::class, 'store'])->name('employee.store');
    Route::get('employee/{user}/edit', [PartnerPersonController::class, 'edit'])->name('employee.edit');
    Route::put('employee/{user}', [PartnerPersonController::class, 'update'])->name('employee.update');
    Route::put('employee/{user}/delete', [PartnerPersonController::class, 'softDelete'])->name('employee.softDelete'); //usery chi jnjum
    Route::get('/generate-pdf', [CompanyController::class, 'generatePDF'])->name("employee.export_pdf");


    Route::get('/user_groups', [UserGroupController::class, 'show'])->name('user_groups');
    Route::get('/user_groups/add', [UserGroupController::class, 'add'])->name('user_groups.add');
    Route::post('/user_groups/store', [UserGroupController::class, 'store'])->name('user_groups.store');
    Route::get('/user_groups/{group}/edit', [UserGroupController::class, 'edit'])->name('user_groups.edit');
    Route::put('/user_groups/{group}', [UserGroupController::class, 'update'])->name('user_groups.update');
    Route::put('groups/{group}/delete', [UserGroupController::class, 'destroy'])->name('user_groups.destroy');

    Route::get('/user_group_user/{group}', [UserGroupUserController::class, 'show'])->name('user_group_user');
    Route::get('/user_group_user/{group}/add', [UserGroupUserController::class, 'add'])->name('user_group_user.add');
    Route::post('/user_group_user/{group}/store', [UserGroupUserController::class, 'store'])->name('user_group_user.store');
    Route::delete('/user_group_user/{userGroupId}/users/{userId}', [UserGroupUserController::class, 'detach'])->name('user_group_user.detach');


//    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
//    Route::post('/sections', [SectionController::class, 'store'])->name('sections.store');
//    Route::put('/sections/{section}', [SectionController::class, 'update'])->name('sections.update');
//    Route::delete('/sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy');
    Route::resource('sections', SectionController::class);

    Route::get('/sections/{section}/permissions', [SectionPermissionController::class, 'show'])->name('sections.permissions');


//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
Route::get('/send-test-email', [TestController::class, 'sendTestEmail'])->name('send.test.email');


//config
Route::get('/verification-required', function () {
    return view('auth.verify');
})->name('verification.notice')->middleware(['verified', 'auth']);

Route::get('/{any}', function () {
    return redirect('/')->with('message', 'You have been redirected to the home page.');
})->where('any', '.*');
