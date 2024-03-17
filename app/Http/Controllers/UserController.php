<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    public function index()
    {
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
    
    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();

            // $request->validate([
            //     'name' => 'required|string|max:255',
            //     'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            //     'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
            // ]);

            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->getRealPath();
                $uploadedFile = Cloudinary::upload($avatarPath, [
                    'folder' => 'avatars',
                ]);

                $user->avatar = $uploadedFile->getSecurePath();
            }

            $user->update($request->all());

            return response()->json(['message' => 'Perfil actualizado correctamente', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el perfil: ' . $e->getMessage()], 500);
        }
    }
}
