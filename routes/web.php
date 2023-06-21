<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix' => 'images', 'as' => 'images.'], function () {
        Route::get('/', [ImageController::class, 'index'])->name('index');
        Route::get('/list', [ImageController::class, 'contributorSpecificList'])->name('list');
        Route::get('/create', [ImageController::class, 'create'])->name('create');
        Route::post('/upload', [ImageController::class, 'store'])->name('store');
        Route::get('/{image}/download', [ImageController::class, 'download'])->name('download');
    });

});

require __DIR__.'/auth.php';
