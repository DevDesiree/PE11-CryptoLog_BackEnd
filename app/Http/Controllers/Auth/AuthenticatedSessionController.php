<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        try {
            $request->authenticate();

            $user = $request->user();
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json([
                'message' => "Has iniciado sesión correctamente, bienvenid@ {$user->name}!", 'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Error al iniciar sesión. Por favor, verifica tus credenciales.'], 500);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
