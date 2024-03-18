<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Symfony\Component\Translation\t;

class UserController extends Controller
{
    public function index(Request $request)
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

    public function show($id)
    {
        $validator = Validator::make(['user_id' => $id], [
          'user_id' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
              'success' => false,
              'message' => 'Validation failed',
              'fails' => $validator->errors()
            ], 400);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
              'success' => false,
              'message' => 'The user with the requested identifier does not exist',
              'fails' => [
                'user_id' => ['User not found']
              ]
            ], 404);
        }

        return response()->json([
          'success' => true,
          'user' => new UserResource($user)
        ]);
    }
}
