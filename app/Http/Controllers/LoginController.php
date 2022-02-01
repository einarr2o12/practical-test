<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use App\Traits\ResponserTraits;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ResponserTraits;
    /**
     * @var LoginService $loginService;
     */
    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }
    public function login(LoginRequest $request)
    {
        $inputs = $request->validated();

        $result = $this->loginService->login($inputs);

        return $this->responseSuccess('success', [
            'token' => $result
        ]);
    }
}
