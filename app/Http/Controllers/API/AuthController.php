<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;

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

        $tokenResponse = parent::issueToken($request->withParsedBody($parsedBody));
        $token = $tokenResponse->getContent();

        // $tokenInfo will contain the usual Laravel Passport token response.
        $tokenInfo = json_decode($token, true);

        $username = $request->getParsedBody()['username'];
        $user = User::whereEmail($username)->first();
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

    public function refresh(ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();

        $parsedBody['grant_type'] = 'refresh_token';
        $parsedBody['client_id'] = config('services.passport.client_id');
        $parsedBody['client_secret'] = config('services.passport.client_secret');

        return parent::issueToken($request->withParsedBody($parsedBody));
    }

    public function logout()
    {
        auth()->user()->tokens->each->delete();

        return response()->json('Logged out successfully', 200);
    }
}
