<?php

use App\Livewire\RegistrationPage;
use Illuminate\Support\Facades\Route;

use App\Livewire\LoginPage;

Route::get('/', LoginPage::class);

// Login and register pages.
Route::get("/login", LoginPage::class);
Route::get("/register", RegistrationPage::class);