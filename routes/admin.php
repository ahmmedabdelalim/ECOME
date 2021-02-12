<?php

use Illuminate\Support\Facades\Route;
use Whoops\Run;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\LanguagesController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Routing\RouteGroup;

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
define('PAGINATION_COUNT',10);

Route::group(['middleware'=>'auth:admin'], function () {


    Route::get('/',[ DashboardController::class, 'index'])->name('admin.dashboard');

    ##################### begin of route for languages #########3

    Route::group(['prefix' => 'languages'], function () {

    Route::get('/',[ LanguagesController::class, 'getAllLanguages'])->name('admin.languages');
    Route::get('create',[ LanguagesController::class, 'create'])->name('admin.languages.create');
    Route::post('store',[ LanguagesController::class, 'store'])->name('admin.languages.store');
    Route::get('edit/{id}',[ LanguagesController::class, 'edit']) -> name('admin.languages.edit');
    Route::post('update/{id}',[ LanguagesController::class, 'update']) -> name('admin.languages.update');
    Route::get('delete/{id}',[ LanguagesController::class, 'delete']) -> name('admin.languages.delete');

        
    });

});





Route::group([ 'middleware'=>'guest:admin' ], function () {
    
    Route::get('login',[ LoginController::class, 'getlogin'])->name('get.admin.login');
    Route::post('checklogin',[ LoginController::class, 'checklogin'])->name('admin.login');
    Route::post('logout', [ LoginController::class, 'logout'])->name('admin.logout');




});
