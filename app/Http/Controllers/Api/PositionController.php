<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PositionCollection;
use App\Http\Resources\PositionResource;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function show()
    {
        $positions = Position::all();

        if ($positions->isEmpty()) {
            return response()->json([
              'success' => false,
              'message' => 'Positions not found'
            ], 422);
        }

        return response()->json([
          'success' => true,
          'positions' => new PositionCollection($positions),
        ]);
    }
}
