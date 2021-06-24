<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\Api\AccountUpdateRequest;
use App\Http\Requests\Api\AuthorizationRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends ApiController
{

    public function __construct()
    {
        $this->user = Auth::guard('api')->user();
        $this->middleware('auth:api')->except(['login', 'register']);
    }

    public function show()
    {
        return $this->responded("Show information successfully", Auth::user());
    }

    public function update(AccountUpdateRequest $request)
    {
        $validated = $request->validated();
        $array_pw = isset($validated['old_password']) ? [
            'password' => bcrypt($validated['new_password'])
        ] : [];
        if (isset($validated['old_password'], $validated['new_password']) && $validated['old_password'] == $validated['new_password']) {
            return $this->respondedError("Update information failed", [
                'new_password' => ['Mật khẩu mới không được trùng với mật khẩu cũ.']
            ]);

        } elseif (isset($validated['old_password'], $validated['new_password']) && !Hash::check($validated['old_password'], $this->user->password)) {
            return $this->respondedError("Update information failed", [
                'old_password' => ['Mật khẩu cũ không hợp lệ.']
            ]);

        } else {
            unset($validated['old_password'], $validated['new_password']);

            $this->user->update(array_merge(
                $validated,
                $array_pw
            ));
            return $this->responded("Update information successfully", $this->user);
        }

    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        if (!$token = auth('api')->attempt($request->only('email', 'password'))) {
            return $this->respondedError("Unauthorized", [], 401);
        }

        $data = $this->respondedWithToken($token);
        return $this->responded("Login success", $data);
    }

    public function register(AuthorizationRegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = array_merge(
            $request->validated(),
            [
                'password' => bcrypt($request->password)
            ]);

        //dd($validated);
        $data = User::create($validated);
        //$data = collect($data)->except('id');
        return $this->responded("Register success", $data);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth('api')->logout();
        return $this->responded("Logout success");
    }

    public function refresh(): \Illuminate\Http\JsonResponse
    {
        $token = auth('api')->refresh();
        $data = $this->respondedWithToken($token);
        return $this->responded("Refresh token success", $data);
    }


    private function respondedWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60 * 24,
        ];
    }

}
