<?php

return [
    'jwt_secret_key' => env('JWT_SECRET_KEY', 'somesecret123'),
    'jwt_algorithm' => env('JWT_ALGORITM', 'HS256'),
    'jwt_exp_day' => env('JWT_EXP_DAY', '7'),
];