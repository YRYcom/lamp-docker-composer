<?php

use App\Http\Controllers\DocumentOperation\DownloadController;
use App\Http\Controllers\DocumentOperation\ListController as DocumentOperationListController;
use App\Http\Controllers\DocumentOperation\RemoveController;
use App\Http\Controllers\DocumentOperation\StoreController;
use App\Http\Controllers\Operation\CreateController as OperationCreateController;
use App\Http\Controllers\Operation\DeleteController;
use App\Http\Controllers\Operation\EditController;
use App\Http\Controllers\Operation\IndexController;
use App\Http\Controllers\Operation\ListController;
use App\Http\Controllers\Operation\SaveController;
use App\Http\Controllers\Operation\UpdateController;
use App\Http\Controllers\OperationExport\CreateController as OperationExportCreateController;
use App\Http\Controllers\OperationExport\DownloadController as OperationExportDownloadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app.dashboard');
});

Route::get('operation', IndexController::class)->name('operation');
Route::get('operation/liste', ListController::class)->name('operation.liste');
Route::get('operation/creer', OperationCreateController::class)->name('operation.creer');
Route::post('operation/creer', SaveController::class)->name('operation.enregistrer');
Route::get('operation/supprimer', DeleteController::class)->name('operation.supprimer');
Route::get('operation/editer', EditController::class)->name('operation.editer');
Route::post('operation/editer', UpdateController::class)->name('operation.modifier');


Route::post('documentoperation/enregistrer', StoreController::class)->name('documentoperation.enregistrer');
Route::post('documentoperation/supprimer', RemoveController::class)->name('documentoperation.supprimer');
Route::get('documentoperation/telecharger', DownloadController::class)->name('documentoperation.telecharger');
Route::get('documentoperation/liste', DocumentOperationListController::class)->name('documentoperation.liste');

Route::get('operationexport/creer', OperationExportCreateController::class)->name('operationexport.creer');
Route::get('operationexport/telecharger', OperationExportDownloadController::class)->name('operationexport.telecharger');


