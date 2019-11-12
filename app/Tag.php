<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'tag_video');
    }
}
