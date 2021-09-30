<?php

use App\Http\Controllers\Operation\IndexController;
use App\Http\Controllers\Operation\ListController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app.dashboard');
});

Route::get('operation', IndexController::class)->name('operation');
Route::get('operation/liste', ListController::class)->name('operation.liste');
