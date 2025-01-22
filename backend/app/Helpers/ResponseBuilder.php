<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseBuilder
{
    /**
     * Build a success response.
     *
     * @param array $data
     * @param string|null $message
     * @param int $status
     * @return JsonResponse
     */
    public static function success(
        array $data = [],
        ?string $message = null,
        int $status = 200
    ): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message ?? 'Successful.',
            'data' => $data,
        ], $status);
    }

    /**
     * Build an error response.
     *
     * @param string $message
     * @param array $errors
     * @param int $status
     * @return JsonResponse
     */
    public static function error(
        string $message,
        array $errors = [],
        int $status = 400
    ): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    /**
     * Build a response for newly created resource.
     *
     * @param array $data
     * @param string|null $message
     * @return JsonResponse
     */
    public static function created(
        array $data = [],
        ?string $message = null
    ): JsonResponse
    {
        return self::success($data, $message, 201);
    }
}
