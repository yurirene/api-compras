<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    protected $table = 'listas';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function produtos()
    {
        return $this->belongsTo(Produto::class, 'id', 'produto_id');
    }
}
