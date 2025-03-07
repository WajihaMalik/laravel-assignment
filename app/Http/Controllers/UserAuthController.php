<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class UserAuthController extends Controller
{
    public function registerUser(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('YourAppName')->plainTextToken;
        SendEmailJob::dispatch($user);

        return response()->json([
            'message' => 'Registration successful!',
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    public function loginUser(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 401);
        }

        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->json([
            'message' => 'Login successful!',
            'token' => $token,
        ], 200);
    }

    public function getUsers(Request $request)
    {
        $users = User::paginate(10);

        return UserResource::collection($users);
    }
}
