<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage;

use FilesystemStorage\Application\FilesystemStorage;
use FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath;
use FilesystemStorage\Domain\ValueObject\File;
use FilesystemStorage\Domain\ValueObject\UserId;

interface UserAvatarFilesystemStorageInterface extends AssetExistsInterface
{
    /**
     * Return file contents
     *
     * @param \FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath $path
     * @return string
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\FileReadException
     */
    public function load(UserAvatarAssetPath $path): string;

    /**
     * @param \FilesystemStorage\Domain\ValueObject\UserId $userId
     * @param \FilesystemStorage\Domain\ValueObject\File $file
     * @return \FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\FileWriteException
     */
    public function save(UserId $userId, File $file): UserAvatarAssetPath;

    /**
     * @param \FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath $path
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\FileRemoveException
     */
    public function remove(UserAvatarAssetPath $path): void;
}
