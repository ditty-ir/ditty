<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'post_categories';
    public $timestamps = false;
    public $casts = [
        'in_home_page' => 'boolean'
    ];
    // public $appends = ['url'];

    protected $fillable = ['title', 'in_home_page', 'parent_id'];

    public function setInHomePageAttribute($value)
    {
        $this->attributes['in_home_page'] = (bool) $value;
    }

    public function getUrlAttribute()
    {
        return url('/categories', $this->id) . '/' . str_slug($this->title, '-', false);
    }
}
