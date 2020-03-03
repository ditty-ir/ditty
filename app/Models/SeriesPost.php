<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesPost extends Model
{
    protected $fillable = [
        'post_id',
        'series_id',
    ];

    public function info()
    {
        return $this->hasOne(Post::class, 'id', 'post_id')
            ->select('id', 'title');
    }
}
