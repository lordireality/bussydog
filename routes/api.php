<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/Security/Auth', [App\Http\Controllers\SecurityController::class, 'Auth']);
Route::post('/Security/Register', [App\Http\Controllers\SecurityController::class, 'Register']);
Route::post('/Security/LogOut', [App\Http\Controllers\SecurityController::class, 'LogOut']);

//Route::get('/Messages/GetDialogues', [App\Http\Controllers\MessageController::class, 'GetMyDialogues']);
//Route::get('/Messages/GetDialogueMessages', [App\Http\Controllers\MessageController::class, 'GetDialogueMessages']);

Route::get('/Wiki/Search',[App\Http\Controllers\WikiController::class , 'ArticleSearch']);

Route::post('/Wiki/SaveArticle',[App\Http\Controllers\WikiController::class , 'SaveArticle']);
Route::post('/Wiki/CreateStructure',[App\Http\Controllers\WikiController::class , 'CreateStructure']);
Route::post('/Wiki/DeleteStructure',[App\Http\Controllers\WikiController::class , 'DeleteStructure']);


Route::post('/Index/AddWidgetZone',[App\Http\Controllers\UIPageController::class , 'AddWidgetZone']);

Route::post('/Index/RemoveWidgetZone',[App\Http\Controllers\UIPageController::class , 'RemoveWidgetZone']);

Route::get('/Index/GetAllWidgets',[App\Http\Controllers\UIPageController::class , 'GetAllWidgets']);

Route::post('/Index/SetWidgetToZone',[App\Http\Controllers\UIPageController::class , 'SetWidgetToZone']);


//
