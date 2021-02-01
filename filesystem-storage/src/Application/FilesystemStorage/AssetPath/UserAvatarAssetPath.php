<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage\AssetPath;

use FilesystemStorage\Application\FilesystemStorage\UserAvatarFilesystemStorageInterface;
use FilesystemStorage\Application\ValueObject\RelativePath;
use FilesystemStorage\Domain\ValueObject\UserAvatarImage;

final class UserAvatarAssetPath extends AssetPath implements UserAvatarImage
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

    /**
     * @param string $filename
     * @return \FilesystemStorage\Application\ValueObject\RelativePath
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public static function createRelativePathForFilename(string $filename): RelativePath
    {
        return static::baseDirectory()->append($filename);
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    protected static function baseDirectory(): RelativePath
    {
        return RelativePath::fromString('/avatars');
    }
}
