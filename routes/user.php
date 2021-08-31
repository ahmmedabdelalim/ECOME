<?php

use App\Http\Controllers\User\LoginController;
use Illuminate\Support\Facades\Route;

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



Route::group(['middleware'=>'auth:user'], function () {
    Route::get('/',[ LoginController::class, 'index'])->name('user.dashboard');
});


////////////////////

Route::group([ 'middleware'=>'guest:user' ], function () {

    Route::get('login',[ LoginController::class, 'getlogin'])->name('get.admin.login');
    Route::post('checklogin',[ LoginController::class, 'checklogin'])->name('user.login');
    //Route::post('logout', [ LoginController::class, 'logout'])->name('admin.logout');




});
