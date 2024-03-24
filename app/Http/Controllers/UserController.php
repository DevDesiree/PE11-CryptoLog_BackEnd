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

                // Obtiene los datos del formulario
                $formData = $request->only(['name', 'email']);

                // Verifica si se ha cargado un archivo
                if ($request->hasFile('avatar')) {
                    $avatar = $request->file('avatar');

                    // Carga la imagen en Cloudinary
                    $uploadedFile = Cloudinary::upload($avatar->getRealPath(), [
                        'folder' => 'avatars',
                    ]);

                    // Obtiene la URL y el public_id de la imagen cargada en Cloudinary
                    $avatarUrl = $uploadedFile->getSecurePath();
                    $publicId = $uploadedFile->getPublicId();

                    // Actualiza el perfil del usuario con la URL de la imagen y el public_id
                    $formData['avatar'] = $avatarUrl;
                    $formData['public_id'] = $publicId;
                }

                // Actualiza el perfil del usuario
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
                    $historicals = Historical::latest()->get();
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
