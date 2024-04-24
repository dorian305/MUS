<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\MediaController;

Route::get("/getkey", [ApiKeyController::class, "index"]);
Route::post("/upload", [MediaController::class, "index"]);