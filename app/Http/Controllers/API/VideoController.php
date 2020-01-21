<?php

namespace App\Http\Controllers\API;

use App\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Screencast\Traits\BaseApi;
use App\Http\Resources\VideoResource;
use App\Screencast\Repositories\Contracts\VideoInterface;

class VideoController extends Controller
{
    use BaseApi;

    protected $video = null;

    // VideoInterface is the interface
    public function __construct(VideoInterface $video)
    {
        $this->video = $video;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Left is relationship names. Right is include names.
        // Avoids exposing relationships and whatever not directly set
        $possibleRelationships = [
            'tags' => 'tags',
        ];
        $videos = $this->nestingFlexibility($request, $this->video, $possibleRelationships);
        return VideoResource::collection($videos)
        ->additional(['message' => 'Videos retrieved successfully',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // create record and pass in only fields that are fillable
        $video = $this->video->store($request->only($this->video->getModel()->fillable));
        return new VideoResource($video);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        return new VideoResource($this->video->show($video->load('tags')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $this->video->update($request->only($this->video->getModel()->fillable), $video);
        return new VideoResource($video->refresh());
    }

    /**
      * Remove the specified resource from storage.
      *
      * @param  \App\Video  $video
      * @return \Illuminate\Http\Response
      */
    public function destroy(Video $video)
    {
        $this->video->delete($video);
        return response()->json(['message' => 'successfully remove video'], 204);
    }
}
