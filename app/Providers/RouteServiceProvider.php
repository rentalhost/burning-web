<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

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
