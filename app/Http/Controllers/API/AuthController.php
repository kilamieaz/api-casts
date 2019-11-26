<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use Illuminate\Support\Facades\Cookie;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\AuthorizationServer;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class AuthController extends AccessTokenController
{
    const REFRESH_TOKEN = 'refresh_token';

    public function __construct(
        AuthorizationServer $server,
        TokenRepository $tokens,
        JwtParser $jwt
    ) {
        parent::__construct($server, $tokens, $jwt);
    }

    public function login(ServerRequestInterface $request)
    {
        // $tokenInfo will contain the usual Laravel Passport token response.
        $tokenInfo = $this->attemptLogin('password', $request);

        $email = $request->getParsedBody()['email'];
        $user = User::whereEmail($email)->first();

        $data = $this->data($tokenInfo, ['user' => $user]);

        return response()->json($data)->withCookie(self::REFRESH_TOKEN, $tokenInfo->refresh_token, 864000, null, null, false, true);
    }

    public function refresh(ServerRequestInterface $request)
    {
        // $tokenInfo will contain the usual Laravel Passport token response.
        $tokenInfo = $this->attemptRefresh('refresh_token', $request);

        $data = $this->data($tokenInfo);

        return response()->json($data)->withCookie(self::REFRESH_TOKEN, $tokenInfo->refresh_token, 864000, null, null, false, true);
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

    public function logout()
    {
        auth()->user()->tokens->each->delete();

        return response()->json('Logged out successfully', 200);
    }

    public function attemptLogin($grantType, $request)
    {
        $parsedBody = $request->getParsedBody();

        $parsedBody['username'] = $parsedBody['email'];
        unset($parsedBody['email']);

        $tokenResponse = $this->proxy($grantType, $parsedBody, $request);
        return json_decode($tokenResponse->getContent());
    }

    public function attemptRefresh($grantType, $request)
    {
        $parsedBody = $request->getParsedBody();

        $parsedBody['refresh_token'] = Cookie::get(self::REFRESH_TOKEN);

        $tokenResponse = $this->proxy($grantType, $parsedBody, $request);
        return json_decode($tokenResponse->getContent());
    }

    public function data($info, array $data = [])
    {
        return array_merge($data, [
            'token_type' => $info->token_type,
            'expires_in' => $info->expires_in,
            'access_token' => $info->access_token,
        ]);
    }

    public function proxy($grantType, array $parsedBody = [], $request)
    {
        $parsedBody = array_merge($parsedBody, [
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'grant_type' => $grantType
        ]);

        return parent::issueToken($request->withParsedBody($parsedBody));
    }
}
