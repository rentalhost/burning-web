<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Services;

class BurningService
{
    public static function getWorkingDirectory(): string
    {
        return str_replace('\\', '/', file_get_contents(storage_path('cwd')));
    }
}
