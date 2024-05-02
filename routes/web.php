<?php

use App\Livewire\RegistrationPage;
use Illuminate\Support\Facades\Route;

use App\Livewire\LoginPage;

Route::get('/', function () {
    return view('index');
})->middleware("auth:sanctum");

// Login and register pages.
Route::get("/login", LoginPage::class);
Route::get("/register", RegistrationPage::class);