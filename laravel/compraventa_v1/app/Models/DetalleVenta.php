<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    public function venta(){
        return $this->belongsTo(Venta::class,'sale_id');
    }

    public function producto(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
