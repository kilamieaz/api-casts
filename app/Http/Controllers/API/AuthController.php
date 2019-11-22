<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class AuthController extends AccessTokenController
{
    public function __construct(
        AuthorizationServer $server,
        TokenRepository $tokens,
        JwtParser $jwt
    ) {
        parent::__construct($server, $tokens, $jwt);
    }

    public function login(ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();

        $parsedBody['grant_type'] = 'password';
        $parsedBody['client_id'] = config('services.passport.client_id');
        $parsedBody['client_secret'] = config('services.passport.client_secret');

        return parent::issueToken($request->withParsedBody($parsedBody));
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

    public function refresh(ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();

        $parsedBody['grant_type'] = 'refresh_token';
        $parsedBody['client_id'] = config('services.passport.client_id');
        $parsedBody['client_secret'] = config('services.passport.client_secret');
        $parsedBody['refresh_token'] = $request->refreshToken;

        return parent::issueToken($request->withParsedBody($parsedBody));
    }

    public function logout()
    {
        auth()->user()->tokens->each->delete();

        return response()->json('Logged out successfully', 200);
    }
}
