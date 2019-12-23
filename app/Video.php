<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['name', 'description', 'thumbnail', 'video_url', 'duration', 'code_summary', 'published_at'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_video');
    }

    public function connectTagToVideo($tagId)
    {
        return $this->tags()->attach($tagId);
    }

    public function disconnectTagFromVideo($tagId)
    {
        return $this->tags()->detach($tagId);
    }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
