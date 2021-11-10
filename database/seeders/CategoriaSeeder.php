<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            'Alimentos',
            'Congelados',
            'Temperos',
            'Condimentos',
            'Limpeza',
            'Higiene',
            'Hortifruti',
            'Outros'
        ];

        foreach ($categorias as $categoria) {
            Categoria::create(['nome' => $categoria]);
        }
    }
}
