<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Services;

use ColinODell\Json5\Json5Decoder;
use Illuminate\Support\Arr;

class BurningService
{
    /** @var array|null */
    private static $burningDefaultJson;

    /** @var array|null */
    private static $burningJson;

    public static function getBurningDefaultJson(): ?array
    {
        return self::$burningDefaultJson ?? self::$burningDefaultJson = self::loadJson('/vendor/rentalhost/burning-php/burning.json');
    }

    public static function getBurningDirectory(): string
    {
        return self::getWorkingDirectory() . '/' . Arr::get(self::getBurningJson(), 'burningDirectory');
    }

    public static function getBurningJson(): ?array
    {
        if (self::$burningJson) {
            return self::$burningJson;
        }

        return self::$burningJson = array_replace(self::getBurningDefaultJson(), self::loadJson('/burning.json', []));
    }

    public static function getBurningSessions(): array
    {
        $sessions            = [];
        $sessionFolderFormat = str_replace('{%requestMs}', '.+', Arr::get(self::getBurningJson(), 'burningSessionFolderFormat'));

        foreach (glob(self::getBurningDirectory() . '/*', GLOB_NOSORT | GLOB_ONLYDIR) as $sessionFolder) {
            if (preg_match('<' . $sessionFolderFormat . '>', basename($sessionFolder))) {
                $sessions[] = $sessionFolder;
            }
        }

        return $sessions;
    }

    public static function getWorkingDirectory(): string
    {
        return str_replace('\\', '/', file_get_contents(storage_path('cwd')));
    }

    private static function loadJson(string $path, ?array $default = null): ?array
    {
        $jsonPath = self::getWorkingDirectory() . $path;

        return is_file($jsonPath)
            ? Json5Decoder::decode(file_get_contents($jsonPath), true)
            : $default;
    }
}
