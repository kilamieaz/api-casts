<?php

namespace App\Screencast\Traits;

trait BaseApi
{
    public function nestingFlexibility($request, $model, $possibleRelationships)
    {
        $requestedEmbeds = explode(',', $request->include); //['tags', 'etc']

        // Check for potential ORM relationships, and convert from generic "include" names
        $eagerLoad = array_keys(array_intersect($possibleRelationships, $requestedEmbeds));
        return  $model::with($eagerLoad)->get();
    }
}
