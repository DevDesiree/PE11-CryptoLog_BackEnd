<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite_coin;
use Illuminate\Support\Facades\Auth;

class FavoriteCoinController extends Controller
{
    public function getFavorites(Request $request)
    {
        if (Auth::user()) {
            try {
                $userId = $request->user()->id;

                $favorites = Favorite_coin::where('user_id', $userId)->pluck('coin_name');

                return response()->json($favorites);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error al obtener las monedas favoritas' . $e->getMessage()], 500);
            }
        }
    }

    public function addFavorite(Request $request)
    {
        if (Auth::user()) {
            try {
                $userId = $request->user()->id;
                $coinName = $request->coin_name;

                $favoriteCoin = Favorite_coin::create([
                    'user_id' => $userId,
                    'coin_name' => $coinName,
                ]);

                return response()->json(['message' => 'Moneda añadida a favoritos', $favoriteCoin], 201);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error al añadir moneda a favoritos' . $e->getMessage()], 500);
            }
        }
    }


    public function removeFavorite(Request $request, $coinName)
    {
        if (Auth::user()) {
            try {
                $userId = $request->user()->id;

                Favorite_coin::where('user_id', $userId)
                    ->where('coin_name', $coinName)
                    ->delete();

                return response()->json(['message' => 'Moneda eliminada de favoritos'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error al borrar moneda de favoritos' . $e->getMessage()], 500);
            }
        }
    }
}
