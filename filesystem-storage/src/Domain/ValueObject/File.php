<?php
declare(strict_types=1);

namespace FilesystemStorage\Domain\ValueObject;

interface File
{
    public function getContents(): string;
}
