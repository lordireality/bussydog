<?php

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

/*Приветственная страница */
Route::get('/', function () {
    return view('welcome');
});
/*страница с ошибками (пустая)*/
Route::get('/error',function () {
    return view('error');
})->name('error');

Route::get('/index', [App\Http\Controllers\UIPageController::class, 'LoadMainPage'])->name('index');

/*Страница авторизации*/
Route::get('/login', [App\Http\Controllers\SecurityController::class, 'LogOnPage'])->name('LogOnPage');

Route::get('/register', [App\Http\Controllers\SecurityController::class, 'RegisterPage'])->name('register');

Route::get('/verify-account',[App\Http\Controllers\SecurityController::class,'VerifyAccount'])->name('verifyAccount');

Route::get('/user/{id}',[App\Http\Controllers\SecurityController::class,'UserProfile'])->name('user');

Route::get('/UI-IconPack', [App\Http\Controllers\UIPageController::class, 'IconPack'])->name('IconPack');

Route::get('/organization',[App\Http\Controllers\SecurityController::class,'OrganizationPage'])->name('OrganizationPage');


/*Дебаг Layout-a */
Route::get('/TEST/layout',function () {
    return view('/templates/PageCoreWithoutAuth');
})->name('layoutTest');