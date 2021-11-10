<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function get(Categoria $categoria)
    {
        $retorno = array_map(function ($item) {
            return [
                'label' => $item['nome'],
                'value' => $item['id']
            ];
        }, $categoria->produtos->toArray());
        
        return response()->json($retorno, 200);
    }
}
