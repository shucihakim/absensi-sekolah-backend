<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

function getCurrentTime($format = null): Carbon
{
    $dateTime = new DateTime('now'); // Adjust 'Asia/Jakarta' if needed
    $formated = $dateTime->format('Y-m-d\TH:i:s.u\Z');
    $time = Carbon::parse($formated);
    return $format ? $time->format($format) : $time;
}

function generateJWT($payload): string
{
    $key = \config('api.jwt_secret_key');
    $algoritm = \config('api.jwt_algorithm');
    $issuedAt = time();
    // jwt valid untuk 24 jam (60 detik * 60 menit * 24 jam * hari)
    $expDay = \config('api.jwt_exp_day');
    $expirationTime = $issuedAt + 60 * 60 * 24 * (int) $expDay;
    $payload['iat'] = $issuedAt;
    $payload['exp'] = $expirationTime;
    $jwt = JWT::encode($payload, $key, $algoritm);
    return $jwt;
}

function getTokenData(Request $request): object
{
    $key = \config('api.jwt_secret_key');
    $token = $request->bearerToken();
    return JWT::decode($token, new Key($key, 'HS256'));
}

function uploadPath(string $filename, string $folder = ''): string
{
    $baseurl = URL::to('/');
    $url = "$baseurl/uploads/$folder/$filename";
    return $url;
}

function profilePath(string $filename): string
{
    $baseurl = URL::to('/');
    $path = "profiles";
    $url = "$baseurl/$path/$filename";
    return $url;
}

function absensiPath(string $filename): string
{
    $baseurl = URL::to('/');
    $path = "uploads/absensi";
    $url = "$baseurl/$path/$filename";
    return $url;
}

function aboutPath(string $filename): string
{
    $baseurl = URL::to('/');
    $path = "tentang";
    $url = "$baseurl/$path/$filename";
    return $url;
}

function textAvatar(string $text): string
{
    $color = "343a55";
    $background = "f1f0f3";
    $name = urlencode($text);
    $url = "https://ui-avatars.com/api/?name=$name&color=$color&background=$background";
    return $url;
}