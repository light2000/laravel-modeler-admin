<?php

namespace Modules\Auth\Services;
use Modules\User\Models\Administrator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AdministratorAuthService
{
    public const TOKEN_NAME = 'administrator-login';

    public function login(string $account, string $password): array
    {
        $administrator = Administrator::query()
            ->where('account', $account)
            ->first();

        if (! $administrator) {
            throw ValidationException::withMessages([
                'account' => __('auth.account.non-existent'),
            ]);
        }

        if (! Hash::check($password, $administrator->password)) {
            throw ValidationException::withMessages([
                'password' => __('auth.password.error'),
            ]);
        }

        return [
            'administrator' => $administrator,
            'permissions'   => $administrator->getAllPermissions()->pluck('name')->values(),
            'token'         => $administrator->createToken(self::TOKEN_NAME)->plainTextToken,
        ];
    }

    public function logout()
    {
        if (auth('administrator')->check()) {
            auth('administrator')->user()->currentAccessToken()->delete();
        }
    }
}
