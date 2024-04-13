<?php

use App\Http\Controllers\ActionController\ActionController;
use App\Http\Controllers\Auth\PartnerVerificationController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\DocumentController\DocumentController;
use App\Http\Controllers\FileController\FileController;
use App\Http\Controllers\InboxController\InboxController;
use App\Http\Controllers\PartnerPerson\PartnerPersonController;
use App\Http\Controllers\PDFSignatureController;
use App\Http\Controllers\Section\PermissionController;
use App\Http\Controllers\Section\SectionController;
use App\Http\Controllers\SectionPermission\SectionPermissionController;
use App\Http\Controllers\TCPDFController;
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
//Route::post('/login', 'Auth\LoginController@login')->middleware('blockIPAfterAttempts');//todo nayel

Route::group(['namespace' => 'writing', 'middleware' => ['verified', 'auth', 'pass_changed']], function () {
    Route::get('/', [IndexController::class, '__invoke'])->name('writing.index');
});

Route::get('/tcpdf',[TCPDFController::class,'downloadPdf']);
Route::get('/generatepdf', [PDFSignatureController::class, 'generatePDFWithSignature']);

Route::middleware(['verified', 'auth'])->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
});
Route::middleware(['verified', 'auth', 'pass_changed'])->group(function () {
    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox');


    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/add', [DocumentController::class, 'add'])->name('documents.add');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('documents/{document}/history', [DocumentController::class, 'history'])->name('documents.history');
    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');


    Route::get('/documents/{document}/send_to_confirmation', [ActionController::class, 'send_to_confirmation'])->name('documents.send_to_confirmation');
    Route::post('/documents/{document}/send', [ActionController::class, 'send'])->name('documents.send');

    Route::get('/documents/{document}/confirm', [ActionController::class, 'confirm_show'])->name('documents.confirm_show');
    Route::post('/documents/{document}/confirm', [ActionController::class, 'confirm'])->name('documents.confirm');
    Route::post('/documents/{document}/reject', [ActionController::class, 'reject'])->name('documents.reject');

    Route::get('/documents/{document}/send_to_sign', [ActionController::class, 'send_to_sign'])->name('documents.send_to_sign');
    Route::post('/documents/{document}', [ActionController::class, 'send_to_sign_send'])->name('documents.send_sign');
    Route::get('/documents/{document}/sign', [ActionController::class, 'sign_show'])->name('documents.sign_show');
    Route::post('/documents/{document}', [ActionController::class, 'sign'])->name('documents.sign');
    Route::get('/documents/{document}/finish', [ActionController::class, 'finish'])->name('documents.finish');
    Route::post('/documents/{document}', [ActionController::class, 'finish_store'])->name('documents.finish_store');

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
//Route::get('/verification-required', function () {
//    return view('auth.verify');
//})->name('verification.notice')->middleware(['verified', 'auth']);

//Route::get('/{any}', function () {
//    return redirect('/')->with('message', 'You have been redirected to the home page.');
//})->where('any', '.*');
