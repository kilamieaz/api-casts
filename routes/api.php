<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::middleware(['auth:api'])->group(function () {
        Route::apiResources([
            'users' => 'API\UserController',
            'videos' => 'API\VideoController',
            'tags' => 'API\TagController'
        ]);
        Route::post('logout', 'API\AuthController@logout');
    });
    Route::post('/login', 'API\AuthController@login');
    Route::post('/refresh', 'API\AuthController@refresh');
    Route::post('/register', 'API\AuthController@register');
});
