<?php
declare(strict_types=1);

namespace FilesystemStorage\Domain;

use FilesystemStorage\Domain\ValueObject\File;

interface ChangeAvatarDataInterface
{
    public function getAvatarImage(): File;
}
