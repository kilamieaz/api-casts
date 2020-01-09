<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return new UserResource($request->user()->load('playedVideos'));
    });

    Route::apiResources([
        'users' => 'API\UserController',
        'users/{user}/playedVideos' => 'API\UserPlayedVideosController',
        'videos/{video}/tags' => 'API\VideoTagsController',
        'videos' => 'API\VideoController',
        'tags' => 'API\TagController'
    ]);
    Route::middleware(['auth:api'])->group(function () {
        Route::post('logout', 'API\AuthController@logout');
    });
    Route::post('/login', 'API\AuthController@login');
    Route::post('/refresh', 'API\AuthController@refresh');
    Route::post('/register', 'API\AuthController@register');
});
