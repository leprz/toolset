<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage\Exception;

use Exception;

class FileReadException extends Exception
{
    public static function fromPath(string $path): self
    {
        return new self(sprintf('Can not read file [%s]', $path));
    }
}
