<?php

declare(strict_types = 1);

return [
    'name'      => env('APP_NAME', 'Burning Web'),
    'env'       => env('APP_ENV', 'local'),
    'debug'     => env('APP_DEBUG', true),
    'url'       => env('APP_URL', 'http://127.0.0.1:8000'),
    'asset_url' => env('ASSET_URL'),
    'timezone'  => env('APP_TIMEZONE', 'UTC'),

    'locale'          => env('APP_LOCALE', 'en'),
    'fallback_locale' => 'en',

    'key'    => env('APP_KEY', 'BURNING//WEB//000000000000000000'),
    'cipher' => 'AES-256-CBC',

    'providers' => [
        /* Laravel Framework Service Providers... */
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /* Package Service Providers... */

        /* Application Service Providers... */
        Rentalhost\BurningWeb\Providers\AppServiceProvider::class,
        Rentalhost\BurningWeb\Providers\RouteServiceProvider::class,
    ]
];
