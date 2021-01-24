<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage\Exception;

use Exception;

class FileWriteException extends Exception
{
    public static function fromPath(string $destinationFilePath): self
    {
        return new self(sprintf('Can not write to path [%s]', $destinationFilePath));
    }
}
