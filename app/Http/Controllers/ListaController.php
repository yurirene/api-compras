<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Lista;
use App\Models\Produto;
use Illuminate\Http\Request;

class ListaController extends Controller
{
    
    public function get()
    {
        $retorno = array();
        $categorias_na_lista = Categoria::whereHas('produtos.lista')->get();
        foreach ($categorias_na_lista as $key => $categoria) {
            $retorno[$key]['categoria'] = $categoria->nome;
            $retorno[$key]['icon'] = $categoria->icon;
            foreach ($categoria->produtos()->whereHas('lista')->get() as $produto) {
                $retorno[$key]['produtos'][] = [
                    'id' => $produto->id,
                    'produto' => $produto->nome,
                    'quantidade' => $produto->lista->quantidade
                ];
            }
        }

        return response()->json($retorno, 200);
    }

    public function add(Request $request)
    {
        try {
            $produto = Produto::findOrFail($request->produto_id);
            if ($produto->lista()->exists()) {
                $quantidade_atual = $produto->lista->quantidade;
                $produto->lista->quantidade = $quantidade_atual + $request->quantidade;
                $produto->lista->save();
                return response()->json(['message' => 'Atualização Realizada com Sucesso!'], 200);
            }
            Lista::create([
                'produto_id' => $produto->id,
                'quantidade' => $request->quantidade
            ]);
            return response()->json(['message' => 'Adição Realizada com Sucesso!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao Realizar Operação!'], 204);
        }
    }

    public function edit(Request $request)
    {
        try {
            $produto = Produto::findOrFail($request->produto_id);
            $produto->lista->quantidade = $request->quantidade;
            $produto->lista->save();
            return response()->json(['message' => 'Atualização Realizada com Sucesso!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao Realizar Operação!'], 204);
        }
    }

    public function delete(Request $request) 
    {
        try {
            $produto = Produto::findOrFail($request->produto_id);
            $produto->lista->delete();
            return response()->json(['message' => 'Remoção Realizada com Sucesso!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao Realizar Operação!'], 204);
        }
    }
}
