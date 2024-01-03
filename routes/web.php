<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\NIPController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLogController;
use App\Http\Controllers\DivisionController;

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

Route::get('/', [AuthController::class, 'redirect']);
Route::middleware(['guest'])->group(function () { 
    Route::controller(AuthController::class)->group(function () {
        Route::match(['get', 'post'], '/register', 'Register')->name('register');
        Route::match(['get', 'post'], '/login', 'Login')->name('login');
        Route::get('/checkpoint', 'CheckpointNIP')->name('checkpoint');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'Logout')->name('logout');
    });
    Route::prefix('dashboard')->group(function () { 
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
            Route::match(['get', 'post'], 'profile/{id}', 'profile')->name('profile');
            Route::match(['get', 'post'], 'profile/{id}/ganti/kata/sandi', 'changePassword')->name('profile.change.password');
        });
        Route::middleware(['role:employee'])->group(function () {
            Route::controller(DocumentController::class)->group(function () {
                Route::get('document/history', 'index')->name('employee.document');
                Route::get('document/detail/employee/{id}', 'detailDocument')->name('employee.detail');
                Route::get('document/download/employee/{id}', 'downloadDocument')->name('employee.download');
                Route::post('document/download/employee/report', 'downloadEmployeeDocuments')->name('employee.download.report');
                Route::match(['get', 'post'],'document/upload/employee/{id}', 'uploadDocument')->name('employee.upload');
                Route::match(['get', 'post'], 'document/generate', 'generateDocument')->name('employee.generate');
                Route::match(['get', 'post'], 'document/update/employee/{id}', 'updateDocument')->name('employee.document.update');
                Route::get('document/search', 'search')->name('search.documents');
            });
        });
        Route::middleware(['role:administrator'])->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('/user', 'index')->name('user.index');
                Route::get('/user/{id}/delete', 'delete')->name('user.delete');
                Route::get('/user/{id}/permanent-delete', 'permanentDelete')->name('user.permanent.delete');
                Route::get('/user/{id}/restore', 'restore')->name('user.restore');
                Route::match(['get', 'post'], '/user/create', 'store')->name('user.create');
                Route::match(['get', 'post'], '/user/{id}/update', 'update')->name('user.update');
            });
            Route::controller(UserLogController::class)->group(function () {
                Route::get('/user/log', 'index')->name('log.index');
                Route::post('/user/log/download', 'downloadLog')->name('log.download.all');
                //in case want to add Create, Update, Delete
            });
            Route::controller(CategoryController::class)->group(function () {
                Route::get('/category', 'index')->name('cat.index');
                Route::get('/category/{id}/delete', 'delete')->name('cat.delete');
                Route::get('/category/{id}/permanent-delete', 'permanentDelete')->name('cat.permanent.delete');
                Route::get('/category/{id}/restore', 'restore')->name('cat.restore');
                Route::match(['get', 'post'], '/category/create', 'store')->name('cat.create');
                Route::match(['get', 'post'], '/category/{id}/update', 'update')->name('cat.update');
            });
            Route::controller(DivisionController::class)->group(function () {
                Route::get('/division', 'index')->name('div.index');
                Route::get('/division/{id}/delete', 'delete')->name('div.delete');
                Route::get('/division/{id}/permanent-delete', 'permanentDelete')->name('div.permanent.delete');
                Route::get('/division/{id}/restore', 'restore')->name('div.restore');
                Route::match(['get', 'post'], '/division/create', 'store')->name('div.create');
                Route::match(['get', 'post'], '/division/{id}/update', 'update')->name('div.update');
            });
            Route::controller(JenisController::class)->group(function () {
                Route::get('/jenis', 'index')->name('jenis.index');
                Route::get('/jenis/{id}/delete', 'delete')->name('jenis.delete');
                Route::get('/jenis/{id}/permanent-delete', 'permanentDelete')->name('jenis.permanent.delete');
                Route::get('/jenis/{id}/restore', 'restore')->name('jenis.restore');
                Route::match(['get', 'post'], '/jenis/create', 'store')->name('jenis.create');
                Route::match(['get', 'post'], '/jenis/{id}/update', 'update')->name('jenis.update');
            });
            Route::controller(DocumentController::class)->group(function () {
                Route::get('/document', 'index')->name('document.index');
                Route::get('/document/delete/{id}', 'delete')->name('document.delete');
                Route::get('/document/permanent-delete/{id}', 'permanentDelete')->name('document.permanent.delete');
                Route::get('/documents/searchs', 'search')->name('searchs.documents');
                Route::get('/document/detail/{id}', 'detailDocument')->name('document.detail');
                Route::match(['get', 'post'], '/document/{id}/update', 'updateDocument')->name('document.update');
                Route::get('/document/download/single/{id}', 'downloadDocument')->name('document.download.single');
                Route::post('/document/download/all', 'downloadAllDocuments')->name('document.download.all');
            });
        });
    });
});