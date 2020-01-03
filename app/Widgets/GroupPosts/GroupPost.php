<?php

namespace App\Widgets\GroupPosts;

use Illuminate\Database\Eloquent\Model;

class GroupPost extends Model
{

    public $table = 'widgets_group_posts';

    protected $fillable = [
        'title',
        'type',
        'value',
    ];
}
