<?php

namespace App\Models;

use App\Traits\Image;
use Illuminate\Support\Str;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use Image, SoftDeletes, Taggable;

    const STATUS_PUBLISHED = 3;
    const STATUS_DRAFT = 2;
    const STATUS_HIDDEN = 1;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'category_id',
        'brief_text',
        'text',
        'cover_image',
        'cnt_comments',
        'status'
    ];

    // protected $hidden = ['id'];

    protected $with = ['user', 'category'];
    protected $appends = ['tags', 'hash_id', 'j_created_at', 'j_updated_at'];

    public function getRouteKey()
    {
        return \Hashids::connection(get_called_class())->encode($this->getKey());
    }

    public function necessaryFields()
    {
        $fields = $this->fillable;
        array_push($fields, 'id', 'created_at', 'updated_at');
        $fields = array_values($fields);
        unset($fields[array_search('text', $fields)]);

        return $fields;
    }

    public function scopeIsPublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public static function boot()
    {
        parent::boot();

        // static::addGlobalScope('status', function (Builder $builder) {
        //     $builder->where('status', self::STATUS_PUBLISHED);
        // });
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->where('status', Comment::STATUS_APPROVED);
            // ->select(['id', 'name', 'text']);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault([
            'title' => 'بدون دسته‌بندی'
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setCoverImageAttribute($value)
    {
        $this->attributes['cover_image'] = $this->storeImage($value, 'cover-images', 900);
    }

    public function getCoverImageAttribute()
    {
        if ($this->attributes['cover_image']) {
            return '/assets/images/cover-images/' . $this->attributes['cover_image'] . '.jpg';
        }
    }

    public function getTagsAttribute()
    {
        $tags = [];

        foreach ($this->tagged as $tag) {
            $tags[] = $tag->tag_name;
        }
        unset($this->tagged);

        return $tags;
    }

    public function getJCreatedAtAttribute()
    {
        if (! empty($this->attributes['created_at'])) {
            return \Morilog\Jalali\CalendarUtils::convertNumbers(
                jdate($this->attributes['created_at'])->format('%d %B %Y - H:i')
            );
        }
    }

    public function getJUpdatedAtAttribute()
    {
        if (! empty($this->attributes['updated_at'])) {
            return \Morilog\Jalali\CalendarUtils::convertNumbers(
                jdate($this->attributes['updated_at'])->format('%d %B %Y - H:i')
            );
        }
    }


    public function getSlugAttribute()
    {
        return Str::slug($this->attributes['slug'], '-', null);
    }

    public function getUrlAttribute()
    {
        if (! empty($this->attributes['id'])) {
            $id = \Hashids::connection(self::class)->encode($this->attributes['id']);

            return url('/posts', $this->slug) . '/' . $id;
        }
    }

    public function getHashIdAttribute()
    {
        if (! empty($this->attributes['id'])) {
            return \Hashids::connection(self::class)->encode($this->attributes['id']);
        }
    }

    public function featured()
    {
        return $this->hasOne(FeaturedPost::class, 'post_id')->select(['post_id']);
    }
}
