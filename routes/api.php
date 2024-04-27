<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiKey\ApiKeyController;
use App\Http\Controllers\Media\DeleteMediaController;
use App\Http\Controllers\Media\UploadMediaController;
use App\Http\Controllers\Media\GetMediaController;
use App\Http\Controllers\Media\GetAllMediaController;

// Authentication.
Route::post("/user-register",   [UserController::class, "register"]);
Route::post("/user-login",      [UserController::class, "login"]);
Route::post("/user-logout",     [UserController::class, "logout"])
    ->middleware("auth:sanctum");

// Api key generation.
Route::get("/apikey-get", [ApiKeyController::class, "index"])
    ->middleware("auth:sanctum");

// Media 
Route::get("/media-get/{id}",   [GetMediaController::class, "index"]);
Route::get("/media-all",        [GetAllMediaController::class, "index"]);
Route::post("/media-delete",    [DeleteMediaController::class, "index"]);
Route::post("/media-upload",    [UploadMediaController::class, "index"]);