<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $table = 'views';

    protected $fillable = [
        "show_id",
        "user_id",
       
    ];

    public $timestamps = true;
}
