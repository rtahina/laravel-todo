<?php

namespace App\Domains\Auth;

use App\Domains\Auth\Enums\TokenAbility;
use App\Helpers\HttpApiResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthService
{
    /**
     * @return string $token
     */
    public function generateToken(User $user): string
    {
        $expirationTime = config('sanctum.expiration');
        settype($expirationTime, 'integer');
        $atExpireTime = now()->addMinutes(intval($expirationTime));
        $accessToken = $user->createToken('api-token', [TokenAbility::ACCESS_API], $atExpireTime);

        return $accessToken->plainTextToken;
    }

    /**
     * @param  array<string, mixed>  $body
     */
    public function sendResponseWithToken(
        string $token,
        array $body = [],
        string $message = 'Success.'
    ): JsonResponse {
        return HttpApiResponse::successResponse(array_merge($body, [
            'token' => $token,
            'type' => 'Bearer',
        ]), $message);
    }
}
