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

    public static function getAppFiles(): array
    {
        $allowedPaths = self::getDirectoriesComposerCompatible();
        $burningJson  = self::getBurningJson();

        if (Arr::get($burningJson, 'includeDevelopmentPaths')) {
            $allowedPaths = array_merge($allowedPaths, self::getDirectoriesComposerCompatible(true));
        }

        $allowedPaths = array_map([ PathService::class, 'normalizeDirectory' ], $allowedPaths);

        return array_merge(... array_map(static function (string $allowedPath) {
            return iterator_to_array(PathService::getFilesRecursively($allowedPath, false, [ 'php' ]), false);
        }, $allowedPaths));
    }

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
        return file_get_contents(storage_path('cwd'));
    }

    private static function getDirectoriesComposerCompatible(?bool $devMode = null): array
    {
        $composerJson     = ComposerService::getComposerJson();
        $workingDirectory = self::getWorkingDirectory();
        $directoryPath    = $devMode !== true ? 'autoload' : 'autoload-dev';

        $files       = Arr::get($composerJson, $directoryPath . '.files', []);
        $directories = Arr::get($composerJson, $directoryPath . '.psr-4', []);

        $files = array_map(static function (string $path) use ($workingDirectory) {
            return realpath($workingDirectory . DIRECTORY_SEPARATOR . $path);
        }, array_filter($files, static function (string $path) use ($workingDirectory) {
            return is_file($workingDirectory . DIRECTORY_SEPARATOR . $path);
        }));

        $directories = array_map(static function (string $path) use ($workingDirectory) {
            return realpath($workingDirectory . DIRECTORY_SEPARATOR . $path) . DIRECTORY_SEPARATOR;
        }, array_filter($directories, static function (string $path) use ($workingDirectory) {
            return is_dir($workingDirectory . DIRECTORY_SEPARATOR . $path);
        }));

        return array_values(array_merge($files, $directories));
    }

    private static function loadJson(string $path, ?array $default = null): ?array
    {
        $jsonPath = self::getWorkingDirectory() . $path;

        return is_file($jsonPath)
            ? Json5Decoder::decode(file_get_contents($jsonPath), true)
            : $default;
    }
}
