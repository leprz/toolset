<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage\Exception;

use Exception;

class FileRemoveException extends Exception
{
    public static function fromPath(string $path): self
    {
        return new self(sprintf('Can not remove file [%s]', $path));
    }
}
