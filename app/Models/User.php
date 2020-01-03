<?php

namespace App\Models;

use App\Traits\Image;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, Image;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'avatar',
        'biography',
        'credentials',
        'social_urls',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
        'level',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function revokeTokens()
    {
        foreach ($this->tokens as $token) {
            $token->revoke();
        }
    }

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function setSocialUrlsAttribute($value)
    {
        $this->attributes['social_urls'] = mb_json_encode($value);
    }

    public function getSocialUrlsAttribute()
    {
        return ! empty($this->attributes['social_urls'])
            ? json_decode($this->attributes['social_urls'])
            : [];
    }

    public function setAvatarAttribute($value)
    {
        if ($this->avatar) {
            $this->deleteImage('avatars', $this->avatar);
        }

        $this->attributes['avatar'] = $this->storeImage($value, 'avatars', [300, 300]);
    }

    public function avatar()
    {
        if ($this->attributes['avatar']) {
            return url('/assets/images/avatars/' . $this->attributes['avatar'] . '.jpg');
        }
    }

    public function isAuthor()
    {
        return $this->level >= 1;
    }

    public function isAdmin()
    {
        return $this->level === 5;
    }

    public function getUrlAttribute()
    {
        return url('@' . $this->attributes['username']);
    }
}
