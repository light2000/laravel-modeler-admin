<?php

namespace Modules\User\Http\Controllers\Administrator;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Requests\Me\UpdatePasswordRequest;
use Modules\User\Http\Requests\Me\UpdateProfileRequest;
use Modules\User\Transformers\Administrator\ProfileResource;

class MeController extends UserController
{
    public function show(Request $request)
    {
        return new ProfileResource($request->user());
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $request->user()->update($request->validated());

        return new ProfileResource($request->user());
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        if (!Hash::check($request->old_password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'old_password' => __('auth.old_password.error'),
            ]);
        }
        $request->user()->update(['password' => $request->new_password]);

        return new BaseResource(null);
    }
}
