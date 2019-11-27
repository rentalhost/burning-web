<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Services;

class PathService
{
    public static function getFilesRecursively(string $path, ?bool $yieldDirectories = null, ?array $allowedExtensions = null): \Generator
    {
        foreach (glob($path . '*', GLOB_NOSORT) as $file) {
            if (is_file($file)) {
                if (!$allowedExtensions || in_array(pathinfo($file, PATHINFO_EXTENSION), $allowedExtensions, true)) {
                    yield $file;
                }
            }
            else if (is_dir($file)) {
                if ($yieldDirectories !== false) {
                    yield $file . '/';
                }

                yield from self::getFilesRecursively($file . '/');
            }
        }
    }

    public static function normalizeDirectory(string $path): string
    {
        return rtrim(self::normalizeFile($path), '/') . '/';
    }

    public static function normalizeFile(string $path): string
    {
        return str_replace('\\', '/', $path);
    }
}
