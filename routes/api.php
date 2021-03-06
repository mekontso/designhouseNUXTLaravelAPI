<?php


use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\User\MeController;
use App\Http\Controllers\User\SettingsController;
use Illuminate\Support\Facades\Route;

Route::post('/',[RegisterController::class,'register']);
Route::post('/register_user',[RegisterController::class,'register']);

// public routes
Route::get('me',[MeController::class,'getMe']);


// Route group for authenticated users only
Route::middleware(['auth:api'])->group(function (){
    Route::post('/logout',[LoginController::class,'logout']);
    // update profile routes
    Route::put('settings/profile',[SettingsController::class,'updateProfile']);
    Route::put('settings/password',[SettingsController::class,'updatePassword']);
});

// Route group for guests
Route::middleware(['guest:api'])->group(function (){
    Route::post('register',[RegisterController::class,'register']);
    Route::post('verification/verify/{user}',[VerificationController::class,'verify'])->name('verification.verify');
    Route::post('verification/resend',[VerificationController::class,'resend']);
    Route::post('login',[LoginController::class,'login']);
    Route::post('password/email',[ForgotPasswordController::class,'sendResetLinkEmail']);
    Route::post('password/reset',[ResetPasswordController::class,'reset'])->name('password.reset');


});
