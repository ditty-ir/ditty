<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    const STATUS_APPROVED  = 3;
    const STATUS_PENDING   = 2;
    const STATUS_REJECTED  = 1;

    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'name',
        'email',
        'text',
        'status'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($comment) {
            $comment->status = Auth::user()->isAuthor() ? self::STATUS_APPROVED : self::STATUS_PENDING;
        });
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function count()
    {
        return $this->morphTo();
    }

    public function setTextAttribute($text)
    {
        $text = preg_replace('/[ \t]+/', ' ', preg_replace("/[\n|\n\r|\r]{3,}/", "\n\n", $text));

        $this->attributes['text'] = clean($text, [
            'HTML.Allowed' => ''
        ]);
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return $value->format('y/m/d H:i');
    // }
}
