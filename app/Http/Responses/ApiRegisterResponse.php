<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class ApiRegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        $token = $request->user()->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $request->user(),
            'access_token' => $token,
        ], 201);
    }
}
