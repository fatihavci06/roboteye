<?php

// app/Helpers/ErrorResponse.php

namespace App\Helpers;

class ErrorResponse
{
    /**
     * Hata yanıtını döndür.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function send(string $message, int $statusCode = 500)
    {
        return response()->json([
            'error' => 'Server Error',
            'message' => $message
        ], $statusCode);
    }
}
