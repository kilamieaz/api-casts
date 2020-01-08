<?php

namespace App\Http\Controllers\API;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Screencast\Traits\BaseApi;
use App\Http\Controllers\Controller;
use App\Screencast\Repositories\Contracts\TagInterface;

class TagController extends Controller
{
    use BaseApi;

    protected $tag = null;

    // TagInterface is the interface
    public function __construct(TagInterface $tag)
    {
        $this->tag = $tag;
    }

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
        $tags = $this->nestingFlexibility($request, $this->tag, $possibleRelationships);
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
        $tag = $this->tag->store($request->only($this->tag->getModel()->fillable));
        return new TagResource($tag->load('videos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return new TagResource($this->tag->show($tag->load('videos')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $this->tag->update($request->only($tag->fillable), $tag);
        return new TagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $this->tag->delete($tag);
        return response()->json(['message' => 'successfully remove tag'], 204);
    }
}
