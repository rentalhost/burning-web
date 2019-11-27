<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Burning;

class ReaderService
{
    public static function getWorkingDirectory(): string
    {
        return file_get_contents(storage_path('cwd'));
    }
}
