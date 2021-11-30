<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id', 'categoria_id');
    }
    
    public function lista()
    {
        return $this->hasOne(Lista::class, 'produto_id', 'id');
    }

    public function comprado()
    {
        return $this->hasMany(CompraItem::class);
    }
}
