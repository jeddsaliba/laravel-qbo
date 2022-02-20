<?php
use Illuminate\Support\Facades\Route;
use Pns\LaravelQbo\Http\Controllers\QboAuthController;
use Pns\LaravelQbo\Http\Controllers\QboCompanyController;

Route::post('/authorize', [QboAuthController::class, 'auth']);
Route::post('/token-save', [QboAuthController::class, 'tokenSave']);

Route::group(['prefix' => 'company'], function() {
    Route::get('', [QboCompanyController::class, 'show']);
});
?>