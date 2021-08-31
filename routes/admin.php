<?php

use Illuminate\Support\Facades\Route;
use Whoops\Run;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\LanguagesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MainCategoriesController;
use App\Http\Controllers\Admin\VendorsController;

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
    ############# end of languages#######



    ########### begin of main_categories#####
    Route::group(['prefix' => 'categories'], function () {

        Route::get('/',[ MainCategoriesController::class, 'getAllCategories'])->name('admin.categories');
        Route::get('create',[ MainCategoriesController::class, 'create'])->name('admin.categories.create');
        Route::post('store',[ MainCategoriesController::class, 'store'])->name('admin.categories.store');
        Route::get('edit/{id}',[ MainCategoriesController::class, 'edit']) -> name('admin.categories.edit');
        Route::post('update/{id}',[ MainCategoriesController::class, 'update']) -> name('admin.categories.update');
        Route::get('delete/{id}',[ MainCategoriesController::class, 'delete']) -> name('admin.categories.delete');

        });

            ########### begin of vendors #####
    Route::group(['prefix' => 'vendors'], function () {

        Route::get('/',[ VendorsController::class, 'index'])->name('admin.vendors');
        Route::get('create',[ VendorsController::class, 'create'])->name('admin.vendors.create');
        Route::post('store',[ VendorsController::class, 'store'])->name('admin.vendors.store');
        Route::get('edit/{id}',[ VendorsController::class, 'edit']) -> name('admin.vendors.edit');
        Route::post('update/{id}',[ VendorsController::class, 'update']) -> name('admin.vendors.update');
        Route::get('delete/{id}',[ VendorsController::class, 'delete']) -> name('admin.vendors.delete');

        });


});


###########################################

Route::group([ 'middleware'=>'guest:admin' ], function () {

    Route::get('login',[ LoginController::class, 'getlogin'])->name('get.admin.login');
    Route::post('checklogin',[ LoginController::class, 'checklogin'])->name('admin.login');
    Route::post('logout', [ LoginController::class, 'logout'])->name('admin.logout');




});
