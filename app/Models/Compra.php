<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getDataCompraAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }

    public function itens()
    {
        return $this->hasMany(CompraItem::class);
    }
}
