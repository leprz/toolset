<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage\Exception;

use Exception;

class AssetNotExistException extends Exception
{
    /**
     * @param string $relativePath
     * @return static
     */
    public static function fromPath(string $relativePath): self
    {
        return new self(sprintf('Asset does not exist in path %s', $relativePath));
    }
}
