<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// post
Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);
