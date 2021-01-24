<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage;

use FilesystemStorage\Application\ValueObject\RelativePath;

interface AssetExistsInterface
{
    /**
     * @param \FilesystemStorage\Application\ValueObject\RelativePath $relativePath
     * @return bool
     */
    public function exists(RelativePath $relativePath): bool;
}
