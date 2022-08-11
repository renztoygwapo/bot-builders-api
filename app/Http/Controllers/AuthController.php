<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function auth(Login $request)
    {
        $user = resolve('UserService')->findByEmail($request->email);
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'error' => ['The provided credentials are incorrect.'],
            ]);
        }
        return $this->responseWithToken($user, ['message' => 'User authenticated']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function me()
    {
        $user= Auth::user();
        return $user;
    }

    /**
     * Create response with token
     *
     * @param App\Models\User $user
     * @param array $data
     * @param string status
     * @return \Illuminate\Http\Response
     */
    private function responseWithToken($user, $data, $status = 200)
    {
        // create token
        $token = $user->createToken('Personal Access Token');

        // merge data and generated token
        return response()->json(array_merge(
            (array) $data,
            [
                'user' => $user,
                'access_token'  => $token->plainTextToken,
                'token_type'    => 'Bearer',
                'expires_at'    => $token->accessToken->expires_at
            ]
        ), $status);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
