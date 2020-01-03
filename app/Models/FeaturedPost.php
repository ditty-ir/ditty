<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedPost extends Model
{
    protected $fillable = ['post_id', 'order'];


    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
