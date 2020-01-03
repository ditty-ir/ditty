<?php
namespace App\Classes;

use \Response as ParentResponse;

class Response extends ParentResponse
{

    public static function error($message, $code = 500, $data = null)
    {
        return response()->json([
            'status' => 0,
            'error' => $message,
            'data' => $data,
        ], $code);
    }

    public static function success($message, $data = null)
    {
        return response()->json([
            'status' => 1,
            'message' => $message,
            'data' => $data,
        ]);
    }
}