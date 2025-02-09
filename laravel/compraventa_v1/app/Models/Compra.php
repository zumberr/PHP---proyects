<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'user_id',
        'tipodocumento_id',
        'total_cost',
        'purchase_date',
        'status',
        'pdf_path',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tipodocumento(){
        return $this->belongsTo(TipoDocumento::class);
    }

    public function detalles(){
        return $this->hasMany(DetalleCompra::class,'purchase_id');
    }
}
