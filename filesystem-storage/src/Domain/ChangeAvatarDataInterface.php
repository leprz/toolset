<?php

declare(strict_types=1);

namespace FilesystemStorage\Domain;

use FilesystemStorage\Domain\ValueObject\FileInterface;

interface ChangeAvatarDataInterface
{
    public function getAvatarImage(): FileInterface;
}
