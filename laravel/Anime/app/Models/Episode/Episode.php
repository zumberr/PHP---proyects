<?php

namespace App\Models\Episode;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $table = 'episodes';

    protected $fillable = [
        "show_id",
        "episode_name",
        "video",
        "thumbnail",
       
    ];

    public $timestamps = true;
}
