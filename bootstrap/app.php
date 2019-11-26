<?php

declare(strict_types = 1);

$app = new Illuminate\Foundation\Application($_ENV['APP_BASE_PATH'] ?? dirname(__DIR__));

$app->singleton(Illuminate\Contracts\Http\Kernel::class, Rentalhost\BurningWeb\Http\Kernel::class);
$app->singleton(Illuminate\Contracts\Console\Kernel::class, Rentalhost\BurningWeb\Console\Kernel::class);
$app->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, Rentalhost\BurningWeb\Exceptions\Handler::class);

return $app;
