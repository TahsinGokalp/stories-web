<?php

namespace App\Http\Responses;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request): JsonResponse|RedirectResponse|Response
    {
        if($request->wantsJson()){
            return response()->json(['two_factor' => false]);
        }

        return Auth::user()->hasRole(User::PARENT)
            ? redirect()->intended(config('fortify.home'))
            : redirect()->intended();
    }

}
