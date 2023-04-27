<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Http\Requests\Users\RegisterRequest;
use App\Http\Controllers\Controller;


class RegisterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "aboutYou" => $request->aboutYou
        ]);

        $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'ok' => true,
            'message' => "Usuario creado satisfactoriamente"
        ], 201);
    }
}
