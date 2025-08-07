<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function auth(Request $request) {
        $user = User::where('login', $request->get('login'))->firstOrFail();

        if (!Hash::check($request->password, $user['password'])) {
            throw new AuthenticationException();
        }

        return new JsonResponse(['token' => $user->createToken($user['login'])]);
    }
}
