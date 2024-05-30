<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $type = 'admin';
        $key = \config('api.jwt_secret_key');
        $token = request()->bearerToken();
        if (empty($token)) {
            return api_failed('Bearer token tidak ada', null, 401);
        }
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        if ($decoded->type == $type) {
            return $next($request->merge(['tokenData' => (array) $decoded]));
        } else {
            return api_failed('Maaf anda tidak memiliki akses', null, 401);
        }
    }
}
