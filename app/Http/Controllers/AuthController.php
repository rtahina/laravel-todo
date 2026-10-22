<?php

namespace App\Http\Controllers;

use App\Domains\Auth\AuthService;
use App\Helpers\HttpApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $service
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (! Auth::attempt($credentials)) {
            return HttpApiResponse::unauthorized();
        }

        $user = Auth::user();
        $token = $this->service->generateToken($user);

        return $this->service->sendResponseWithToken($token, [
            'user' => UserResource::make($user),
        ]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make((string) $request->password),
        ]);

        $credentials = $request->only('email', 'password');
        if (! Auth::attempt($credentials)) {
            return HttpApiResponse::unauthorized();
        }

        $user = Auth::user();
        $token = $this->service->generateToken($user);

        return $this->service->sendResponseWithToken($token, [
            'user' => UserResource::make($user),
        ],
            'User registered successfully.'
        );
    }

    public function logout(Request $request): JsonResponse
    {
        if (Auth::check()) {
            $request->user()->tokens()->delete();
        }

        return HttpApiResponse::successResponse(message: 'Successfully logged out.');
    }
}
