<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'tipodocumento_id',
        'total_price',
        'sale_date',
        'status',
        'payment_method',
        'pdf_path',
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tipodocumento(){
        return $this->belongsTo(TipoDocumento::class);
    }

    public function detalles(){
        return $this->hasMany(DetalleVenta::class,'sale_id');
    }
}
