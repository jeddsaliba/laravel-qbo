<?php
use Illuminate\Support\Facades\Route;
use Pns\LaravelQbo\Http\Controllers\QboAuthController;
use Pns\LaravelQbo\Http\Controllers\QboCompanyController;
use Pns\LaravelQbo\Http\Controllers\QboCustomerController;
use Pns\LaravelQbo\Http\Controllers\QboInvoiceController;

Route::post('/authorize', [QboAuthController::class, 'auth']);
Route::post('/token-save', [QboAuthController::class, 'tokenSave']);

Route::group(['prefix' => 'company'], function() {
    Route::get('', [QboCompanyController::class, 'show']);
});

Route::group(['prefix' => 'customer'], function() {
    Route::post('', [QboCustomerController::class, 'store']);
    Route::get('/list', [QboCustomerController::class, 'list']);
    Route::get('/all', [QboCustomerController::class, 'listAll']);
    Route::get('/{id}', [QboCustomerController::class, 'show']);
});

Route::group(['prefix' => 'invoice'], function() {
    Route::post('', [QboInvoiceController::class, 'store']);
    Route::get('/list', [QboInvoiceController::class, 'list']);
    Route::get('/all', [QboInvoiceController::class, 'listAll']);
    Route::post('/send/{id}', [QboInvoiceController::class, 'sendMail']);
    Route::post('/delete/{id}', [QboInvoiceController::class, 'deleteInvoice']);
    Route::get('/{id}', [QboInvoiceController::class, 'show']);
});

Route::group(['prefix' => 'payment'], function() {
    Route::post('', [QboPaymentController::class, 'store']);
});
?>