<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HttpApiResponse
{
    public static function successResponse(
        array $data = [],
        string $message = 'Success.',
        int $code = Response::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    public static function errorResponse(
        array $errors = [],
        string $message = 'Something went wrong.',
        int $code = Response::HTTP_UNPROCESSABLE_ENTITY
    ): JsonResponse {
        return response()->json([
            'status' => false,
            'errors' => $errors,
            'message' => $message,
        ], $code);
    }

    public static function unauthorized(): JsonResponse
    {
        return self::errorResponse(message: 'Unauthorized.', code: Response::HTTP_UNAUTHORIZED);
    }
}
