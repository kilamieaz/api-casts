<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use App\Video;
use Illuminate\Http\Request;
use App\Screencast\FactoryMethod\Used\PivotRelationship;
use App\Screencast\FactoryMethod\Products\UserPlayedVideos;

class UserPlayedVideosController extends Controller
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
    public function store(Request $request, User $user)
    {
        PivotRelationship::connecting(new UserPlayedVideos($user, $request->video_id));
        return new UserResource($user->load('playedVideos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Video $playedVideo)
    {
        PivotRelationship::disconnecting(new UserPlayedVideos($user, $playedVideo->id));
        return response()->json(['message' => 'successfully remove from played videos'], 204);
    }
}
