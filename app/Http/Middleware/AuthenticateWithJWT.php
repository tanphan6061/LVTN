<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Exception;

class AuthenticateWithJWT
{

    public function handle(Request $request, Closure $next)
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();
            //if (!$user = auth()->user()) throw new Exception("Unauthorized"); //fail
            //$user = auth()->userOrFail(); //fail
            //if (!$user = Auth::user()) throw new Exception("Unauthorized"); //fail
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->respondedError("Token is Invalid");
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->respondedError("Token is Expired");
            }else{
                return $this->respondedError("Unauthorized");
            }
        }
        //dd($user);
        return $next($request);
    }

    /**
     * Respond with json error message.
     *
     * @param $message
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondedError($message, $errors = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'status_code' => 401,
            'data' => $errors,
            'message' => $message,
        ]);
    }
}
