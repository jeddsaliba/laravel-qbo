<?php
use Illuminate\Support\Facades\Route;
use Pns\LaravelQbo\Http\Controllers\QboAuthController;

Route::post('/authorize', [QboAuthController::class, 'auth']);
Route::post('/token-save', [QboAuthController::class, 'tokenSave']);

?>