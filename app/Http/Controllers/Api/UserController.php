<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'page' => 'integer|min:1',
          'count' => 'integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
              'success' => false,
              'message' => 'Validation failed',
              'fails' => $validator->errors()
            ], 422);
        }

        $page = $request->has('page') ? $request->get('page') : 1;
        $count = $request->has('count') ? $request->get('count') : 5;

        $users = User::paginate($count);
        $users->appends(['count' => $count]);

        return response()->json([
          'success' => true,
          'page' => $page,
          'total_pages' => $users->lastPage(),
          'total_users' => $users->total(),
          'count' => $count,
          'links' => [
            'next_url' => $users->nextPageUrl(),
            'prev_url' => $users->previousPageUrl(),
          ],
          'users' => new UserCollection($users),
        ]);
    }
}
