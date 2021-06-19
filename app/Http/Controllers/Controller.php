<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
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

    protected function toObjectCollection($array)
    {
        return collect($array)->map(function ($item) {
            return (object)$item;
        });
    }
}
