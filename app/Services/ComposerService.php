<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Services;

use Illuminate\Support\Arr;

class ComposerService
{
    /** @var array|null */
    private static $composerJson;

    public static function getPackageName(): ?string
    {
        return Arr::get(self::getComposerJson(), 'name');
    }

    public static function isAvailable(): bool
    {
        return self::getComposerJson() !== null;
    }

    private static function getComposerJson(): ?array
    {
        if (self::$composerJson === null) {
            $composerJsonPath = BurningService::getWorkingDirectory() . '/composer.json';

            if (is_file($composerJsonPath)) {
                self::$composerJson = json_decode(file_get_contents($composerJsonPath), true, 512, JSON_THROW_ON_ERROR);
            }
        }

        return self::$composerJson;
    }
}
