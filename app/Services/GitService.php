<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Services;

class GitService
{
    /** @var bool|null */
    private static $isAvailable;

    public static function exec(string $command): ?string
    {
        $procSpecs    = [ [ 'pipe', 'r' ], [ 'pipe', 'w' ] ];
        $procHandle   = proc_open('git ' . $command, $procSpecs, $procPipes, BurningService::getWorkingDirectory());
        $procContents = stream_get_contents($procPipes[1]);

        proc_close($procHandle);

        if (!$procContents) {
            return null;
        }

        return rtrim($procContents);
    }

    public static function getCurrentBranchName(): ?string
    {
        if (!self::isAvailable()) {
            return null;
        }

        return substr(self::exec('branch'), 2);
    }

    public static function getLastCommitHash(): ?string
    {
        if (!self::isAvailable()) {
            return null;
        }

        return self::exec('rev-parse HEAD');
    }

    public static function getLastTag(): ?string
    {
        if (!self::isAvailable()) {
            return null;
        }

        return self::exec('describe --abbrev=0 --tags');
    }

    public static function isAvailable(): bool
    {
        if (self::$isAvailable === null) {
            self::$isAvailable = self::exec('--version') !== null;
        }

        return self::$isAvailable;
    }
}
