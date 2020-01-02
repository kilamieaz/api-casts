<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $videoResource = VideoResource::collection($this->whenLoaded('playedVideos'));
        return [
            'id' => (int) $this->id,
            'name' => (string) $this->name,
            'email' => (string) $this->email,
            // 'password' => (string) $this->password,
            'played_video_ids' => $videoResource->collection == null ? $videoResource : $this->playedVideos()->pluck('video_id'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
