<?php

declare(strict_types=1);

namespace FilesystemStorage\Domain\ValueObject;

interface UserAvatarImageInterface
{
    /**
     * @return \FilesystemStorage\Domain\ValueObject\RelativePathInterface
     */
    public function getRelativePath(): RelativePathInterface;

    /**
     * @return string
     */
    public function __toString(): string;
}
