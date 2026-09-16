<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class ApiLoginResponse implements LoginResponseContract
{
    public function toResponse($request): JsonResponse
    {
        $token = $request->user()->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $request->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}
