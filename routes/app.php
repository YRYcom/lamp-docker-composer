<?php

use App\Http\Controllers\Operation\CreateController;
use App\Http\Controllers\Operation\DeleteController;
use App\Http\Controllers\Operation\EditController;
use App\Http\Controllers\Operation\IndexController;
use App\Http\Controllers\Operation\ListController;
use App\Http\Controllers\Operation\SaveController;
use App\Http\Controllers\Operation\UpdateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app.dashboard');
});

Route::get('operation', IndexController::class)->name('operation');
Route::get('operation/liste', ListController::class)->name('operation.liste');
Route::get('operation/creer', CreateController::class)->name('operation.creer');
Route::post('operation/creer', SaveController::class)->name('operation.enregistrer');
Route::get('operation/supprimer', DeleteController::class)->name('operation.supprimer');
Route::get('operation/editer', EditController::class)->name('operation.editer');
Route::post('operation/editer', UpdateController::class)->name('operation.modifier');
