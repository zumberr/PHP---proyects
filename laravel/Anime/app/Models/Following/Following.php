<?php

namespace App\Models\Following;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    use HasFactory;

    protected $table = 'followings';

    protected $fillable = [
        "show_id",
        "user_id",
        "show_image",
        "show_name",
       
    ];

    public $timestamps = true;
}
