<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAll
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = \config('api.jwt_secret_key');
        $token = request()->bearerToken();
        if (empty($token)) {
            return api_failed('Bearer token tidak ada', null, 401);
        }
        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return $next($request->merge(['tokenData' => (array) $decoded]));
        } catch (ExpiredException $e) {
            return api_failed('Token telah kadaluarsa', null, 401);
        } catch (\Exception $e) {
            return api_failed('Terjadi kesalahan saat memverifikasi token', null, 401);
        }
    }
}
