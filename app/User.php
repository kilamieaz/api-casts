<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function playedVideos()
    {
        return $this->belongsToMany(Video::class, 'user_played_videos');
    }

    public function addPlayedVideos($videoId)
    {
        return $this->playedVideos()->attach($videoId);
    }

    public function removePlayedVideos($videoId)
    {
        return $this->playedVideos()->detach($videoId);
    }
}
