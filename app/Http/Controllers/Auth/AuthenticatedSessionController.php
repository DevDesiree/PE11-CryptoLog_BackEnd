<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

use App\Models\Historical;

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

            Historical::create([
                'user_id' => $user->id,
                'action' => 'Inicio de sesión',
                'device' => $request->header('User-Agent'), 
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'message' => "Has iniciado sesión correctamente, bienvenid@ {$user->name}!", 'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Error al iniciar sesión. Por favor, verifica tus credenciales.'], 500);
        }
    }

    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            Historical::create([
                'user_id' => $user->id,
                'action' => 'Cierre de Sesión',
                'device' => $request->header('User-Agent'),
                'ip_address' => $request->ip()
            ]);
        }

        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Sesión cerrada exitosamente.']);
    }

}
