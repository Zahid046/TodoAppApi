<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public static function success($msg = 'Task successful', $data = [], $type = null)
    {
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => $msg,
            'data' => $data,
        ]);
    }
    public static function error($msg = 'An error occurred', $error = [], $type = null)
    {
        return response()->json([
            'success' => false,
            'code' => 400,
            'message' => $msg,
            'data' => $error,
        ]);
    }
}
