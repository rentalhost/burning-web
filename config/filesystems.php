<?php

declare(strict_types = 1);

return [
    'default' => env('FILESYSTEM_DRIVER', 'local'),

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root'   => storage_path('app'),
        ],

        'public' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'url'        => env('APP_URL', 'http://127.0.0.1:8000') . '/storage',
            'visibility' => 'public',
        ]
    ]
];
