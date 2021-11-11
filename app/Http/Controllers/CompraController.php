<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function get()
    {
        $compra = Compra::where('status', 1)->first();
        if ($compra) {
            return response()->json($compra, 200);
        }
        return response()->json(false, 204);
    }

    public function iniciar(Request $request)
    {
        $compra = Compra::where('status', 1)->count();
        if ($compra) {
            return response()->json(['message' => 'Já Existe uma Compra Aberta!'], 204);
        }
        try {
            Compra::create([
                'supermercado' => $request->supermercado,
                'data_compra' => date('Y-m-d'),
                'valor_total' => 0
            ]);
            return response()->json(['message' => 'Compra Iniciada com Sucesso!'], 200);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return response()->json(['message' => 'Erro ao Realizar Operação!'], 204);
        }
    }
}
