<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    //

    protected $user;

    public function __construct()
    {
        $this->user = Auth::guard('api')->user();
    }


    protected function responded($message, $data = [], $statusCode = 200): \Illuminate\Http\JsonResponse
    {
        return $this->response('success', $message, $data, $statusCode);
    }

    public function respondedError($message, $errors = [], $statusCode = 400): \Illuminate\Http\JsonResponse
    {
        return $this->response('error', $message, $errors, $statusCode);
    }

    private function response($status, $message, $data, $statusCode): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            [
                'status' => $status,
                'status_code' => $statusCode,
                'data' => $data,
                'message' => $message
            ]
        );
    }
}
