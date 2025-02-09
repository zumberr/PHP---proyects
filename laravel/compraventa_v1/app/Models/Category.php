<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public static $rules = [
        'name' => 'required|unique:categories|max:255',
        'description' => 'nullable|string',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
