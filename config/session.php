<?php

declare(strict_types = 1);

use Illuminate\Support\Str;

return [
    'driver'   => env('SESSION_DRIVER', 'file'),
    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,
    'encrypt'         => false,

    'files'   => storage_path('framework/sessions'),
    'lottery' => [ 2, 100 ],

    'cookie' => env('SESSION_COOKIE', Str::slug(env('APP_NAME', 'Burning Web'), '_') . '_session'),

    'path'      => '/',
    'domain'    => env('SESSION_DOMAIN'),
    'secure'    => env('SESSION_SECURE_COOKIE', false),
    'http_only' => true,
    'same_site' => null
];
