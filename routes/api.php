<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiKey\ApiKeyController;
use App\Http\Controllers\Media\DeleteMediaController;
use App\Http\Controllers\Media\UploadMediaController;
use App\Http\Controllers\Media\GetMediaController;
use App\Http\Controllers\Media\GetAllMediaController;

Route::post("/register", [UserController::class, "register"]);
Route::post("/login", [UserController::class, "login"]);
Route::post("/logout", [UserController::class, "logout"])
    ->middleware("auth:sanctum");

Route::get("/getkey", [ApiKeyController::class, "index"])
    ->middleware("auth:sanctum");
Route::get("/media-get/{id}", [GetMediaController::class, "index"]);
Route::get("/media-all", [GetAllMediaController::class, "index"]);

Route::post("/upload", [UploadMediaController::class, "index"]);
Route::post("/media-delete", [DeleteMediaController::class, "index"]);