<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    

    protected $fillable=[
        
    'title',
    'content',
    'image',
    'user_id',
    'published_at',

    ];

    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
