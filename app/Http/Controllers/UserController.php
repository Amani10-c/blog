<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

use App\Http\Resources\UserResource;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        if ($users->count() > 0) {
            return  UserResource::collection($users->load('blog'));
        }
    }
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return response()->json([
            'status' => 200,
            'message' => "user edit successfully"
        ], 200);
    }
    public function store(CreateUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($user) {
            return response()->json([
                'status' => 200,
                'message' => "user created successfully"
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid login credentials'
            ], 401);
        }
    }

    public function Show()
    {
        $user = auth()->user();
        if ($user->id != Auth::id()) {
            return response()->json([
                'message' => 'user is not authorized'
            ], 403);
        }
        return  new UserResource($user->load('blog'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => "user delete successfully"
        ], 200);
    }
}
