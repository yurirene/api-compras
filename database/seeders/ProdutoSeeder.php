<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            'Alimentos' => ['Arroz', 'Feijao', 'Macarrão', 'Cream', 'Craker', 'Presunto', 'Queijo', 'Bolacha', 'Ovo' ],
            'Congelados' => [ 'Frango', 'Porco', 'Carne', 'Linguiça', 'Calabresa', 'Peixe' ],
            'Temperos' => [ 'Cominho', 'Oregano', 'Pimenta do Reino', 'Chimichurri', 'Coentro', 'Colorífico', 'Alho', ],
            'Condimentos' => [ 'Molho de Tomate', 'Ketchup', 'Maionese', 'Molho Ingles', 'Molho Shoyo' ],
            'Limpeza' => [ 'Sabão em Pó', 'Sabão em Barra', 'Desinfetante', 'Detergente', 'Amaciante', 'Limpa Vidro', 'Odorizador', 'Vassoura', 'Rodo', 'Água Sanitária'],
            'Higiene' => [ 'Sabonete','Pasta de Dente','Fio Dental','Escova de Dente','Desodorante','Cotonete','Papel Higienico'],
            'Hortifruti' => ['Maça', 'Melão', 'Tomate', 'Cebola'],
            'Outros' => ['Bombons', 'Refrigerante']
        ];

        foreach ($categorias as $categoria => $produtos) {
            $cat = Categoria::where('nome', $categoria)->first();
            foreach ($produtos as $produto) {
                Produto::create(['nome' => $produto, 'categoria_id' => $cat->id]);
            }
        }
    }
}
