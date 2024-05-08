<?php

use App\Http\Controllers\HomeController;
use App\Jobs\SaveNews;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dispatchSaveNews', [HomeController::class,'dispatchSaveNews'])->name('dispatchSaveNews');