<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'categoria_id', 'id');
    }
}
