<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Services;

class PathService
{
    public static function normalizeDirectory(string $path): string
    {
        return rtrim(self::normalizeFile($path), '/') . '/';
    }

    public static function normalizeFile(string $path): string
    {
        return str_replace('\\', '/', $path);
    }
}
