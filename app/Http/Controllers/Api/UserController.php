<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

use function Symfony\Component\Translation\t;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $user_service)
    {
        $this->userService = $user_service;
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'page' => ['integer', 'min:1'],
          'count' => ['integer', 'min:1']
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
          'user_id' => ['integer', 'min:1'],
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

    public function store(Request $request)
    {
        // TODO: implement token generation and validation
        $validator = Validator::make($request->all(), [
          'name' => ['required', 'string', 'min:2', 'max:60'],
          'email' => [
            'required',
            'unique:users,email',
            'string',
            'min:2',
            'max:100',
            'email:rfc'
          ],
          'phone' => ['required', 'string', 'unique:users,phone', 'regex:#^[\+]{0,1}380([0-9]{9})$#'],
          'position_id' => ['required', 'integer', 'min:1'],
          'photo' => [
            'required',
            'mimes:jpeg,jpg',
            Rule::dimensions()->minWidth(70)->minHeight(70),
            'max:5120'
          ],
          'password' => ['required', 'string']
        ]);

        if (isset($validator->errors()->messages()['email']) || isset($validator->errors()->messages()['phone'])) {
            return response()->json([
              'success' => false,
              'message' => 'User with this phone or email already exist'
            ], 409);
        }

        if ($validator->fails()) {
            return response()->json([
              'success' => false,
              'message' => 'Validation failed',
              'fails' => $validator->errors()
            ], 422);
        }

        $file = $request->file('photo');
        $name = $file->hashName();

        Storage::put("public/images/users/$name", $this->userService->getOptimizedImageData($file));

        $user = User::create([
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'password' => Hash::make($request->get('password')),
          'phone' => $request->get('phone'),
          'position_id' => $request->get('position_id'),
          'photo' => $name
        ]);

        return response()->json([
          'success' => true,
          'user_id' => $user->id,
          'message' => 'New user successfully registered',
        ]);
    }
}
