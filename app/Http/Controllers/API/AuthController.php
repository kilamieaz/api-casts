<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->request->add([
            'username' => $request->email,
            'password' => $request->password,
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'scope' => '*'
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );
        $token = Route::dispatch($proxy)->getContent();
        $tokenInfo = json_decode($token, true);
        $user = User::whereEmail($request->email)->first();
        $tokenInfo = collect($tokenInfo);
        $tokenInfo->put('user', $user);
        return $tokenInfo;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    public function refresh(Request $request)
    {
        $request->request->add([
            'refresh_token' => $request->refresh_token,
            'grant_type' => 'refresh_token',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'scope' => '*'
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );
        return Route::dispatch($proxy)->getContent();
    }

    public function logout()
    {
        auth()->user()->tokens->each->delete();

        return response()->json('Logged out successfully', 200);
    }
}
