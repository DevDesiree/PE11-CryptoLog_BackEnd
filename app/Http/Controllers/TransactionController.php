<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Auth::user()->transaction;
        return response()->json($transaction);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'coin_id' => 'required|exists:coins,id',
                'quantity' => 'required|numeric',
                'price_buy' => 'required|numeric',
                'amount' => 'required|numeric',
                'date_buy' => 'required|date_format:Y-m-d'
                // 'actual_price' => 'required|numeric',
            ]);

            $user = Auth::user();

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'coin_id' => $request->coin_id,
                'quantity' => $request->quantity,
                'price_buy' => $request->price_buy,
                'amount' => $request->amount,
                'date_buy' => $request->date_buy,
                // 'actual_price' => $request->actual_price,
            ]);
            return response()->json([
                'message' => 'La transacción se ha realizado correctamente',
                'transaction' => $transaction,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al realizar la transacción: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'coin_id' => 'required|exists:coins,id',
                'quantity' => 'required|numeric',
                'actual_price' => 'required|numeric',
                'amount' => 'required|numeric',
            ]);

            $transaction = Transaction::findOrFail($id);

            if ($transaction->user_id != Auth::id()) {
                return response()->json(['message' => 'No tienes permiso para actualizar esta transacción'], 403);
            }

            $transaction->update($request->all());

            return response()->json(['message' => 'La transacción se ha actualizado correctamente', 'transaction' => $transaction], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la transacción: ' . $e->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();

            return response()->json(['message' => 'La transacción se ha eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la transacción: ' . $e->getMessage()], 500);
        }
    }
}
