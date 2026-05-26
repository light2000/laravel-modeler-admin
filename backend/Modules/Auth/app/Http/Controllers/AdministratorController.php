<?php

namespace Modules\Auth\Http\Controllers;

use Modules\Auth\Http\Requests\Administrator\LoginRequest;
use Modules\Auth\Services\AdministratorAuthService;
use Modules\Auth\Transformers\Administrator\LoginResource;

class AdministratorController extends AuthController
{
    public function login(LoginRequest $request)
    {
        return new LoginResource(app(AdministratorAuthService::class)->login($request->account, $request->password));
    }

    public function logout()
    {
        app(AdministratorAuthService::class)->logout();
    }
}
