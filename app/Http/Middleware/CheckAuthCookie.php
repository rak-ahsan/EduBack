<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

class CheckAuthCookie
{
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('CheckAuthCookie middleware called on route: ' . $request->path());
        if ($request->hasCookie('auth_token')) {
            $token = $request->cookie('auth_token');
            $sanctumToken = PersonalAccessToken::findToken($token);

            if ($sanctumToken) {
                $user = $sanctumToken->tokenable;
                Auth::setUser($user);

                return $next($request);
            }
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
