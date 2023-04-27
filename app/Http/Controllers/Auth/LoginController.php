<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Login user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'ok' => false,
                'message' => 'Credenciales no válidas',
                'errors' => ['auth' => ['Credenciales no válidas']]
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'ok' => true,
            'accessToken' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }
}
