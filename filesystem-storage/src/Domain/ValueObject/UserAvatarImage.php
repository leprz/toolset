<?php
declare(strict_types=1);

namespace FilesystemStorage\Domain\ValueObject;

interface UserAvatarImage
{
    public function __toString(): string;
}
