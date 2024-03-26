<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\MediaController;

Route::get('/upload/generatekey', [KeyController::class, 'generate']);
Route::post('/upload/media', [MediaController::class, 'upload']);