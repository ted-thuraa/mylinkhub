<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        try {
            /* @var \App\Models\User $user */
            $credentials = $request->validated();

    
            $remember = $credentials['remember'] ?? false;
            unset($credentials['remember']);
            if (!Auth::attempt($credentials, $remember)) {
                return response([
                    'error' => 'the provided credentials are incorrect'
                ], 422);
            }
            $user = Auth::user();
            $token = $user->createToken('main')->plainTextToken;
            return response([
                'user' => $user,
                'token' => $token
            ]);
           

        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage()
            ], 422);
            
        }
        // $request->authenticate();

        // $request->session()->regenerate();

        // //return response()->noContent();
        // return response($request);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        /* @var User $user */
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }
}
