<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\UploadController;

Route::get("/getkey", [ApiKeyController::class, "index"]);
Route::post("/upload", [UploadController::class, "index"]);