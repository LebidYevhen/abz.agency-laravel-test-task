<?php

use App\Http\Controllers\Api\PositionController;
use App\Http\Resources\PositionCollection;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('/positions', [PositionController::class, 'show']);
});


