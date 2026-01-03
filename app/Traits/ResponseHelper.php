<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseHelper
{
    /**
     * Return a success response (JSON or redirect with flash).
     */
    public function success(string $message, array $data = [], bool $json = false): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        if ($json) {
            return response()->json([
                'status' => 'ok',
                'data' => $data,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Return an error response.
     */
    public function error(
        string $message,
        string $code = 'ERR_GENERAL',
        array $details = [],
        int $statusCode = 400,
        bool $json = false
    ): JsonResponse|\Illuminate\Http\RedirectResponse {
        if ($json) {
            return response()->json([
                'status' => 'error',
                'code' => $code,
                'message' => $message,
                'details' => $details,
            ], $statusCode);
        }

        return back()->withErrors(['error' => $message])->withInput();
    }

    /**
     * Return a validation error response.
     */
    public function validationError(
        array $errors,
        bool $json = false
    ): JsonResponse|\Illuminate\Http\RedirectResponse {
        if ($json) {
            return response()->json([
                'status' => 'error',
                'code' => 'ERR_VALIDATION',
                'message' => 'Validation failed.',
                'details' => $errors,
            ], 422);
        }

        return back()->withErrors($errors)->withInput();
    }

    /**
     * Return an unauthorized response.
     */
    public function unauthorized(string $message = 'Unauthorized', bool $json = false): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        if ($json) {
            return response()->json([
                'status' => 'error',
                'code' => 'ERR_UNAUTHORIZED',
                'message' => $message,
            ], 403);
        }

        return back()->withErrors(['error' => $message]);
    }

    /**
     * Return a not found response.
     */
    public function notFound(string $message = 'Resource not found.', bool $json = false): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        if ($json) {
            return response()->json([
                'status' => 'error',
                'code' => 'ERR_NOT_FOUND',
                'message' => $message,
            ], 404);
        }

        abort(404);
    }
}
