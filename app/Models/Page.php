<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'path',
        'post_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id')->select(['id', 'title']);
    }

    public function fullPost()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
