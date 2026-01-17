<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Users;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ForgotPassword;
use Illuminate\Support\Facades\Auth;

Route::get('lang/{locale}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/', function () {
    return view('welcome');
})->middleware('auth')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::get('/users', Users::class)->middleware(['auth', 'admin'])->name('users');
Route::get('/settings', \App\Livewire\Settings::class)->middleware(['auth', 'admin'])->name('settings');
Route::get('/view-profile', \App\Livewire\ViewProfile::class)->middleware('auth')->name('view-profile');