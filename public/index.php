<?php

declare(strict_types = 1);

use Illuminate\Foundation\Application;
use Illuminate\Http\Response;

require __DIR__ . '/../vendor/autoload.php';

/** @var Application $app */
/** @noinspection UsingInclusionOnceReturnValueInspection */
$app = require_once __DIR__ . '/../bootstrap/app.php';

/** @var Illuminate\Contracts\Http\Kernel $kernel */
$kernel  = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();

/** @var Response $response */
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
