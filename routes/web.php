<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildLogController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('image_upload', [MediaController::class, 'upload'])->name('upload');
    Route::resource('buildlogs', BuildLogController::class);
    Route::resource('posts', PostController::class);
    Route::resource('comments', CommentController::class);

});
