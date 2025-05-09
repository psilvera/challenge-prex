<?php

namespace App\Helpers;

class ApiResponse {

    // respuestas

    public static function success(array $data = [], string $message = '', int $code = 200) {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error(string $message = '', int $code = 400, array $data = []) {

        return response()->json([
            'message' => $message,
            'errors' => $data
        ], $code);
    }
}
