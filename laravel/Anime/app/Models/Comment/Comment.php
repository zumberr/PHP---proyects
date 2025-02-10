<?php

namespace App\Models\Comment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;


    protected $table = 'comments';

    protected $fillable = [
        "show_id",
        "user_name",
        "image",
        "comment",
    ];

    public $timestamps = true;
}
