<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\InvoiceController;

// Master Data Routes
Route::get('/status', [MasterDataController::class, 'getAllStatus']);
Route::post('/status', [MasterDataController::class, 'createStatus']);
Route::put('/status/{status}', [MasterDataController::class, 'updateStatus']);
Route::delete('/status/{status}', [MasterDataController::class, 'deleteStatus']);

Route::get('/awalan', [MasterDataController::class, 'getAllAwalan']);
Route::post('/awalan', [MasterDataController::class, 'createAwalan']);
Route::put('/awalan/{awalan}', [MasterDataController::class, 'updateAwalan']);
Route::delete('/awalan/{awalan}', [MasterDataController::class, 'deleteAwalan']);

Route::get('/transport-jenis', [MasterDataController::class, 'getAllTransportJenis']);
Route::post('/transport-jenis', [MasterDataController::class, 'createTransportJenis']);
Route::put('/transport-jenis/{jenis}', [MasterDataController::class, 'updateTransportJenis']);
Route::delete('/transport-jenis/{jenis}', [MasterDataController::class, 'deleteTransportJenis']);

// Invoice Routes
Route::get('/invoices', [InvoiceController::class, 'index']);
Route::post('/invoices', [InvoiceController::class, 'store']);
Route::get('/invoices/{id}', [InvoiceController::class, 'show']);
Route::put('/invoices/{id}', [InvoiceController::class, 'update']);
Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy']);
Route::get('/invoices/{id}/pdf', [InvoiceController::class, 'downloadPdf']);
