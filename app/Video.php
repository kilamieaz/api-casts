<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['name', 'description', 'thumbnail', 'video_url'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_video');
    }
}
