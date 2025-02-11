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
Route::get('/', [App\Http\Controllers\UIPageController::class, 'LoadWelcomePage'])->name('welcome');

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

Route::get('/wiki',[App\Http\Controllers\WikiController::class,'Index'])->name('wiki');

Route::get('/wiki-structure/edit',[App\Http\Controllers\WikiController::class,'EditStructure'])->name('wiki-structure-edit');

Route::get('/wiki-article/{articleid}/view',[App\Http\Controllers\WikiController::class,'ViewArticle'])->name('wiki-article');

Route::get('/wiki-article/{articleid}/edit',[App\Http\Controllers\WikiController::class,'EditArticle'])->name('wiki-article-edit');

Route::get('/wiki-article/create',[App\Http\Controllers\WikiController::class,'CreateArticle'])->name('wiki-article-create');

Route::get('/entity/diagnostics',[App\Http\Controllers\EntityController::class,'DiagnosticsPage'])->name('diagnostics');