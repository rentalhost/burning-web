<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Rentalhost\BurningWeb\Http\Controllers\Controller;
use Rentalhost\BurningWeb\Services\BurningService;
use Rentalhost\BurningWeb\Services\ComposerService;
use Rentalhost\BurningWeb\Services\GitService;

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
}
