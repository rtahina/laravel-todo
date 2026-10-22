<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HttpApiResponse
{
     /**
     * @param array $data
     * @param string $message
     * @param int $code Http response code
     * 
     * @return JsonResponse
     */
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

    /**
     * @param array $errors
     * @param string $message
     * @param int $code Http response code
     * 
     * @return JsonResponse
     */
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

    /**
     * @return JsonResponse
     */
    public static function unauthorized(): JsonResponse
    {
        return self::errorResponse(message: 'Unauthorized.', code: Response::HTTP_UNAUTHORIZED);
    }
}
