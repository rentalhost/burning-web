<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Rentalhost\BurningWeb\Http\Controllers\Api\V1\AppController;

class RouteServiceProvider
    extends ServiceProvider
{
    protected $namespace = 'Rentalhost\BurningWeb\Http\Controllers';

    public function map(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->prefix('/api/v1')
            ->group(static function () {
                Route::get('/app', [ AppController::class, 'app' ]);
                Route::get('/app/sessions', [ AppController::class, 'appSessions' ]);
                Route::get('/app/files', [ AppController::class, 'appFiles' ]);
            });

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(static function () {
                Route::get('/', static function () {
                    return view('home');
                });
            });
    }
}
