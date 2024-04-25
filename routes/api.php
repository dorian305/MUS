<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\GetMedia;
use App\Http\Controllers\GetAllMediaController;

Route::get("/getkey", [ApiKeyController::class, "index"]);
Route::get("media-get/{page}", [GetMedia::class, "index"]);
Route::get("/media-all", [GetAllMediaController::class, "index"]);

Route::post("/upload", [UploadController::class, "index"]);