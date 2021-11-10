<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function get()
    {
        $retorno = array_map(function ($item) {
            return [
                'label' => $item['nome'],
                'value' => $item['id']
            ];
        }, Categoria::get()->toArray());
        return response()->json($retorno, 200);
    }
    
}
