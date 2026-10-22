<?php

namespace App\Domains\Auth;

use App\Domains\Auth\Enums\TokenAbility;
use App\Helpers\HttpApiResponse;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthService
{
    /**
     * @return string $token
     */
    public function generateToken(User $user): string
    {
        $atExpireTime = now()->addMinutes((int) config('sanctum.expiration'));
        $accessToken = $user->createToken('api-token', [TokenAbility::ACCESS_API], $atExpireTime);

        return $accessToken->plainTextToken;
    }

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
