<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historical;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            try {
                $user = Auth::user();

                $userData = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                ];

                return response()->json(['user' => $userData], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al obtener los datos del usuario: ' . $e->getMessage()], 500);
            }
        }
    }

    public function updateProfile(Request $request)
    {
        if (Auth::user()) {
            try {
                $user = $request->user();

                $formData = $request->only(['name', 'email']);

                if ($request->hasFile('avatar')) {
                    $avatar = $request->file('avatar');

                    $uploadedFile = Cloudinary::upload($avatar->getRealPath(), [
                        'folder' => 'avatars',
                    ]);

                    $avatarUrl = $uploadedFile->getSecurePath();
                    $publicId = $uploadedFile->getPublicId();

                    $formData['avatar'] = $avatarUrl;
                    $formData['public_id'] = $publicId;
                }
                
                $user->update($formData);

                return response()->json(['message' => 'Perfil actualizado correctamente', 'user' => $user], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al actualizar el perfil: ' . $e->getMessage()], 500);
            }
        }
    }

    public function getHistoricals(Request $request)
    {
        if (Auth::user()) {
            try {
                $user = $request->user();
    
                if ($user) {
                    $historicals = Historical::where('user_id', $user->id)->latest()->get();
                    return response()->json($historicals);
                } else {
                    return response()->json(['message' => 'Usuario no autenticado.'], 401);
                }
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error al obtener los datos históricos.'], 500);
            }
        }
    }
    
}
