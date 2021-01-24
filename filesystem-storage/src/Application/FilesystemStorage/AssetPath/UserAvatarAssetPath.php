<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage\AssetPath;

use FilesystemStorage\Application\FilesystemStorage\UserAvatarFilesystemStorageInterface;
use FilesystemStorage\Application\ValueObject\RelativePath;

final class UserAvatarAssetPath extends AssetPath
{
    /**
     * @param \FilesystemStorage\Application\ValueObject\RelativePath $relativePath
     * @param \FilesystemStorage\Application\FilesystemStorage\UserAvatarFilesystemStorageInterface $storage
     * @return static
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public static function fromRelativePath(
        RelativePath $relativePath,
        UserAvatarFilesystemStorageInterface $storage
    ): self {
        return new self($relativePath, $storage);
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    protected static function baseDirectory(): RelativePath
    {
        return RelativePath::fromString('/avatars');
    }
}
