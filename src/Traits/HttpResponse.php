<?php

namespace Unk\LaravelApiResponse\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponse
{
    protected function success($data = null, $message = null, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($message = null, $code = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}
