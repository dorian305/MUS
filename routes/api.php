<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DeleteMediaController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\GetMediaController;
use App\Http\Controllers\GetAllMediaController;

Route::get("/getkey", [ApiKeyController::class, "index"]);
Route::get("media-get/{id}", [GetMediaController::class, "index"]);
Route::get("/media-all", [GetAllMediaController::class, "index"]);

Route::post("/upload", [UploadController::class, "index"]);
Route::post("/media-delete", [DeleteMediaController::class, "index"]);