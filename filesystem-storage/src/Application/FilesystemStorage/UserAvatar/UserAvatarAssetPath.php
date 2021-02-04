<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage\UserAvatar;

use FilesystemStorage\Application\FilesystemStorage\AssetPathTrait;
use FilesystemStorage\Application\ValueObject\RelativePath;
use FilesystemStorage\Domain\ValueObject\UserAvatarImageInterface;

/** @psalm-suppress PropertyNotSetInConstructor */
class UserAvatarAssetPath implements UserAvatarImageInterface
{
    use AssetPathTrait;

    /**
     * @param \FilesystemStorage\Application\ValueObject\RelativePath $relativePath
     * @param \FilesystemStorage\Application\FilesystemStorage\UserAvatar\UserAvatarFilesystemStorageInterface $storage
     * @return self
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\AssetNotExistException
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
