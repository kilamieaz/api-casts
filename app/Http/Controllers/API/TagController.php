<?php

namespace App\Http\Controllers\API;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Screencast\Traits\BaseApi;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    use BaseApi;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $possibleRelationships = [
            'videos' => 'videos',
        ];
        $tags = $this->nestingFlexibility($request, new Tag, $possibleRelationships);
        return TagResource::collection($tags)
        ->additional(['message' => 'Tags retrieved successfully',
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
        $tag = Tag::create($request->all());
        return new TagResource($tag->load('videos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return new TagResource($tag->load('videos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $tag->update($request->only($tag->fillable));
        return new TagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(['message' => 'successfully remove tag'], 204);
    }
}
