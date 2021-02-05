<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage\UserAvatar;

use FilesystemStorage\Application\FilesystemStorage\AssetExistsInterface;
use FilesystemStorage\Domain\ValueObject\FileInterface;
use FilesystemStorage\Domain\ValueObject\UserId;

interface UserAvatarFilesystemStorageInterface extends AssetExistsInterface
{
    /**
     * Return file contents
     *
     * @param \FilesystemStorage\Application\FilesystemStorage\UserAvatar\UserAvatarAssetPath $path
     * @return string
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\FileReadException
     */
    public function load(UserAvatarAssetPath $path): string;

    /**
     * @param \FilesystemStorage\Domain\ValueObject\UserId $userId
     * @param \FilesystemStorage\Domain\ValueObject\FileInterface $file
     * @return \FilesystemStorage\Application\FilesystemStorage\UserAvatar\UserAvatarAssetPath
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\FileWriteException
     */
    public function save(UserId $userId, FileInterface $file): UserAvatarAssetPath;

    /**
     * @param \FilesystemStorage\Application\FilesystemStorage\UserAvatar\UserAvatarAssetPath $path
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\FileRemoveException
     */
    public function remove(UserAvatarAssetPath $path): void;
}
