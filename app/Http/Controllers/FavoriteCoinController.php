<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite_coin;
use App\Models\Coin;
use Illuminate\Support\Facades\Auth;

class FavoriteCoinController extends Controller
{
    public function index()
    {
        $favoriteCoins = Auth::user()->favorite_coin;

        return response()->json($favoriteCoins);
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            $request->validate([
                'coin_id' => 'required|exists:coins,id'
            ]);

            $favoriteCoin = Favorite_coin::create([
                'user_id' => $user->id,
                'coin_id' => $request->coin_id
            ]);

            $coinName = Coin::findOrFail($request->coin_id)->name;

            return response()->json(['message' => "La moneda $coinName ha sido agregada a tus favoritos correctamente $favoriteCoin"], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la moneda favorita: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request , $id)
    {
        try {

            $favoriteCoin = Favorite_coin::where('coin_id', $id)
                ->where('user_id', auth()->id())
                ->first();

            if (!$favoriteCoin) {
                return response()->json(['error' => 'La moneda especificada no está marcada como favorita'], 404);
            }

            $coinName = Coin::findOrFail($request->coin_id)->name;

            $favoriteCoin->delete();

            return response()->json(['message' => "La moneda {$coinName} ha sido eliminada de tus favoritos correctamente"], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la moneda favorita: ' . $e->getMessage()], 500);
        }
    }
}
