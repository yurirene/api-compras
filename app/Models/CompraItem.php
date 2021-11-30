<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraItem extends Model
{
    protected $table = 'compra_items';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    } 
}
