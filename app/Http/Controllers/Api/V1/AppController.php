<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Rentalhost\BurningWeb\Http\Controllers\Controller;
use Rentalhost\BurningWeb\Services\BurningService;
use Rentalhost\BurningWeb\Services\ComposerService;
use Rentalhost\BurningWeb\Services\GitService;
use Rentalhost\BurningWeb\Services\PathService;

class AppController
    extends Controller
{
    public function app(): JsonResponse
    {
        if (!GitService::isAvailable()) {
            return JsonResponse::create([ 'message' => 'git command not available' ], 503);
        }

        if (!ComposerService::isAvailable()) {
            return JsonResponse::create([ 'message' => 'composer.json not found' ], 503);
        }

        return JsonResponse::create([
            'path'    => BurningService::getWorkingDirectory(),
            'package' => [
                'name'    => ComposerService::getPackageName(),
                'version' => GitService::getLastTag(),
                'branch'  => GitService::getCurrentBranchName(),
                'commit'  => GitService::getLastCommitHash()
            ]
        ]);
    }

    public function appFiles(): JsonResponse
    {
        $workingDirectory = BurningService::getWorkingDirectory();

        return JsonResponse::create([
            'files' => array_map(static function (\SplFileInfo $fileInfo) use ($workingDirectory) {
                return substr(PathService::normalizeFile($fileInfo->getPathname()), strlen($workingDirectory) + 1);
            }, iterator_to_array(BurningService::getAppDirectoryStructure(), false))
        ]);
    }

    public function appSessions(): JsonResponse
    {
        return JsonResponse::create([
            'sessions' => array_map(static function (string $sessionPath) {
                return [
                    'name'     => basename($sessionPath),
                    'creation' => filectime($sessionPath)
                ];
            }, BurningService::getBurningSessions())
        ]);
    }
}
