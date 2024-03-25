<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CreateJsonCacheApiController extends Controller
{
    public function CreateOrUpdate()
    {
        error_log("Se ha llamado al metodo CreateOrUpdate");

        $coinGeckoApi = env('COIN_API');
    
        $response = Http::get($coinGeckoApi);

        if ($response->successful()) {
    
            $data = $response->json();
            
            $jsonData = json_encode($data);

            Storage::disk('public')->put('api.json', $jsonData);

            return response()->json(['message' => 'JSON actualizado correctamente']);
        } else {
            return response()->json(['error' => 'Error al obtener datos de la API'], 500);
        }
    }
}
