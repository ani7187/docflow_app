<?php

use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\DocumentController\DocumentController;
use App\Http\Controllers\FileController\FileController;
use App\Http\Controllers\PartnerPerson\PartnerPersonController;
use App\Http\Controllers\Section\PermissionController;
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

//Auth::routes();
Auth::routes(['verify' => true]);

Route::group(['namespace' => 'writing', 'middleware' => ['verified', 'auth']], function () {
    Route::get('/', [IndexController::class, '__invoke'])->name('writing.index');
});

Route::middleware(['verified', 'auth'])->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/add', [DocumentController::class, 'add'])->name('documents.add');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::post('upload', [DocumentController::class, 'upload']);

    Route::get('/media/download/{media}', [FileController::class, 'download'])->name('media.download');
    Route::get('/media/download-all/{media}', [FileController::class, 'downloadAll'])->name('media.download-all');
});

Route::middleware(['verified', 'auth', 'role:2'])->group(function () {
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

    Route::resource('sections', SectionController::class);

    Route::get('/sections/{section}/permissions', [PermissionController::class, 'show'])->name('sections.permissions');
    Route::post('/sections/{section}/permissions', [PermissionController::class, 'store'])->name('sections.permissions.store');
    Route::delete('/sections/permissions/{permission}', [PermissionController::class, 'destroy'])->name('sections.permissions.destroy');
});

//Route::get('/send-test-email', [TestController::class, 'sendTestEmail'])->name('send.test.email');
//config
Route::get('/verification-required', function () {
    return view('auth.verify');
})->name('verification.notice')->middleware(['verified', 'auth']);

Route::get('/{any}', function () {
    return redirect('/')->with('message', 'You have been redirected to the home page.');
})->where('any', '.*');
