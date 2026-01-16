<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Users;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', Users::class)->name('users');
