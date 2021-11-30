<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Compra;
use App\Models\CompraItem;
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
            return response()->json(['message' => 'Erro ao Realizar Operação!'], 204);
        }
    }

    public function lista(Request $request)
    {
        try {    
            $retorno = array();
            $categorias_na_lista = Categoria::whereHas('produtos.comprado', function ($sql)  use ($request) {
                return $sql->where('compra_id', $request->compra_id);
            })->get();
            foreach ($categorias_na_lista as $key => $categoria) {
                $retorno[$key]['categoria'] = $categoria->nome;
                $retorno[$key]['icon'] = $categoria->icon;
                $produtos = $categoria->produtos()->with('comprado')->whereHas('comprado', function ($sql)  use ($request) {
                    return $sql->where('compra_id', $request->compra_id);
                })->get();
                foreach ($produtos as $produto) {
                    $retorno[$key]['produtos'][] = [
                        'id' => $produto->id,
                        'produto' => $produto->nome,
                        'quantidade' => $produto->comprado->first()->quantidade,
                        'valor_unitario' => $produto->comprado->first()->valor_unitario,
                        'valor_total' => $produto->comprado->first()->valor_total,
                    ];
                }
            }
            return response()->json($retorno, 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function comprarItem(Request $request)
    {
        try {
            $compra = Compra::where('status', 1)->first();
            CompraItem::create([
                'compra_id' => $compra->id,
                'produto_id' => $request->produto_id,
                'quantidade' => $request->quantidade,
                'valor_unitario' => $request->valor,
                'valor_total' => $request->valor * $request->quantidade
            ]);
            $total_ate_agora = CompraItem::where('compra_id', $compra->id)->selectRaw('sum(valor_total) as valor')->groupBy('compra_id')->first()->valor;
            $compra->update([
                'valor_total' => $total_ate_agora
            ]);
            return response()->json(['message' => 'Operação Realizada com Sucesso!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }

    }

    public function delete(Request $request)
    {
        try {
            $compra = Compra::where('status', 1)->first();
            $produto = CompraItem::where('produto_id', $request->produto_id)->where('compra_id', $compra->id)->first();
            $produto->delete();
            $total_ate_agora = CompraItem::where('compra_id', $compra->id)->selectRaw('sum(valor_total) as valor')->groupBy('compra_id')->first()->valor;
            $compra->update([
                'valor_total' => $total_ate_agora
            ]);
            return response()->json(['message' => 'Remoção Realizada com Sucesso!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao Realizar Operação!'], 204);
        }

    }
}
