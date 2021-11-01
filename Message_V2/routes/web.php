<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\getUsersController;
use App\Http\Controllers\getMessageController;
use App\Http\Controllers\postFileController;
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

Route::get('/readmes2', function () {
    return view('readmes');
});
Route::get('/readmes', [MainController::class, 'readMes']);
Route::get('/getmessage', [getMessageController ::class, 'getMessage'])->name('name','getMessage');
Route::get('/getusers', [getUsersController::class, 'getUsers'])->name('name','getUsers');
Route::get('/getuserinfo', [MainController::class, 'getUserInfo'])->name('name','getUserInfo');
Route::post('/postmessage', [PostController::class, 'postMessage'])->name('name','postMessage');
Route::get('/postmessage', [PostController::class, 'postMessage']);
Route::get('/{any}', [MainController::class, 'EnterOk'])->where('any', '.*');

Route::post('/postfile', [postFileController::class, 'UploadFile'])->name('name','postfile');
