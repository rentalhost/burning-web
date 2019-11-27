<?php

declare(strict_types = 1);

namespace Rentalhost\BurningWeb\Services\Filter;

use Illuminate\Support\Str;
use Iterator;
use Rentalhost\BurningWeb\Services\PathService;

class DirectoryFilter
    extends \FilterIterator
{
    /** @var array|null */
    private $allowedExtensions;

    /** @var array|null */
    private $allowedPrefixes;

    public function __construct(Iterator $iterator, ?array $allowedPrefixes = null, ?array $allowedExtensions = null)
    {
        parent::__construct($iterator);

        $this->allowedPrefixes   = $allowedPrefixes ?? [];
        $this->allowedExtensions = $allowedExtensions;
    }

    public function accept(): bool
    {
        /** @var \SplFileInfo $fileInfo */
        $fileInfo      = $this->current();
        $fileDirectory = PathService::normalizeDirectory($fileInfo->getPath());

        return Str::startsWith($fileDirectory, $this->allowedPrefixes) && (
                $this->allowedExtensions === null ||
                Str::endsWith($fileInfo->getExtension(), $this->allowedExtensions)
            );
    }
}
