<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\LoginPage;

Route::get('/', function () {
    return view('index');
});

// Login page
Route::get("/login", LoginPage::class);