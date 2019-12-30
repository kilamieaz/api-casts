<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'name' => (string) $this->name,
            'description' => (string) $this->description,
            'thumbnail' => (string) $this->thumbnail,
            'video_url' => (string) $this->video_url,
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'duration' => (int) $this->duration,
            'code_summary' => (string) $this->code_summary,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
