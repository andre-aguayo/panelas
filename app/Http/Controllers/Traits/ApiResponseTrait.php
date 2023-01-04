<?php

namespace App\Http\Controllers\Traits;

trait ApiResponseTrait
{
    public function run(callable $fn): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'jsonData' => $fn()
            ]);
        } catch (\Exception $exception) {
            $errors = [
                'success' => false,
                'error' =>
                [
                    'exception_message' => $exception->getMessage(),
                    'exception_code' => $exception->getCode()
                ]
            ];

            return response()->json($errors, 400)->withHeaders($errors);
        }
    }
}
