<?php

namespace App\Http\Controllers\API;

use App\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VideoResource::collection(Video::with('tags')->get())
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
        $video = Video::create($request->all());
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
        return new VideoResource($video->load('tags'));
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
        $video->update($request->only($video->fillable));
        return new VideoResource($video);
    }

    /**
      * Remove the specified resource from storage.
      *
      * @param  \App\Video  $video
      * @return \Illuminate\Http\Response
      */
    public function destroy(Video $video)
    {
        $video->delete();
        return response()->json(['message' => 'successfully remove video'], 204);
    }
}
