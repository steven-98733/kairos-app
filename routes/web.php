<?php

use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.login');
});

Route::get('/menu', [SettingsController::class, 'show'])->name('settings.index');
Route::patch('/menu/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
Route::patch('/menu/password/reset', [SettingsController::class, 'resetPassword'])->name('settings.password.reset');
Route::patch('/menu/profile/email', [SettingsController::class, 'updateEmail'])->name('settings.email.update');
Route::patch('/menu/profile/address', [SettingsController::class, 'updateAddress'])->name('settings.address.update');
Route::patch('/menu/profile/phone', [SettingsController::class, 'updatePhone'])->name('settings.phone.update');
