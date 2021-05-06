<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

Route::post('/',[RegisterController::class,'register']);
Route::post('/register_user',[RegisterController::class,'register']);

// public routes



// Route group for authenticated users only
Route::middleware(['auth:api'])->group(function (){
    Route::post('/logout',[LoginController::class,'logout']);
});

// Route group for guests
Route::middleware(['guest:api'])->group(function (){
    Route::post('/register',[RegisterController::class,'register']);
    Route::post('/verification/verify/{user}',[VerificationController::class,'verify'])->name('verification.verify');
    Route::post('/verification/resend',[VerificationController::class,'resend']);
    Route::post('/login',[LoginController::class,'login']);
});
