<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiKey\ApiKeyController;
use App\Http\Controllers\Media\DeleteMediaController;
use App\Http\Controllers\Media\UploadMediaController;
use App\Http\Controllers\Media\GetMediaController;
use App\Http\Controllers\Media\GetAllMediaController;

Route::get("/getkey", [ApiKeyController::class, "index"]);
Route::get("media-get/{id}", [GetMediaController::class, "index"]);
Route::get("/media-all", [GetAllMediaController::class, "index"]);

Route::post("/upload", [UploadMediaController::class, "index"]);
Route::post("/media-delete", [DeleteMediaController::class, "index"]);