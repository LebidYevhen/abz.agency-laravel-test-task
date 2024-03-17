<?php

use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::fallback(function () {
    return response()->json([
      'success' => false,
      'message' => 'Page not found'
    ], 404);
});

Route::prefix('v1')->group(function () {
    Route::get('/positions', [PositionController::class, 'show']);
    Route::get('/users', [UserController::class, 'show']);
});


