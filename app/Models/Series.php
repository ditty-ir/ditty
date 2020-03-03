<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    public $appends = ['selected_posts'];

    protected $fillable = [
        'title'
    ];

    public function posts()
    {
        return $this->hasMany(SeriesPost::class);
    }

    public function getSelectedPostsAttribute()
    {
        $posts = $this->posts;
        $output = [];

        foreach ($posts as $post) {
            $output[] = $post->info;
        }

        return $output;
    }
}
