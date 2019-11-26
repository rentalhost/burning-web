<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Providers;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class AppServiceProvider
    extends ServiceProvider
{
    public static function artisan(): void
    {
        /** @var Kernel $kernel */
        /** @noinspection UsingInclusionOnceReturnValueInspection */
        $kernel = (require_once __DIR__ . '/../../bootstrap/app.php')->make(Kernel::class);

        $input  = new ArgvInput;
        $status = $kernel->handle($input, new ConsoleOutput);

        $kernel->terminate($input, $status);

        exit($status);
    }
}
