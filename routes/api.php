<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\MediaController;

Route::get("/getkey", [KeyController::class, "index"]);
Route::post("/upload/media", [MediaController::class, "upload"]);