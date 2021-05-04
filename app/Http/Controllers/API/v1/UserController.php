<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
{
    public function show()
    {
        return $this->responded("Show information successfully", Auth::user());
    }

    public function update(AccountUpdateRequest $request)
    {

    }
}
