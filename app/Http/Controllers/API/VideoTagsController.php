<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Screencast\FactoryMethod\Supports\VideoTagConnector;
use App\Screencast\FactoryMethod\Used\PivotRelationship;
use App\Video;
use App\Tag;
use Illuminate\Http\Request;

class VideoTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Video $video)
    {
        // $video->connectTagToVideo($request->tag_id);
        PivotRelationship::connecting(new VideoTagConnector($video, $request->tag_id));
        return new VideoResource($video->load('tags'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video, Tag $tag)
    {
        // $video->disconnectTagFromVideo($tag->id);
        PivotRelationship::disconnecting(new VideoTagConnector($video, $tag->id));
        return response()->json(['message' => 'successfully remove tag from video'], 204);
    }
}
