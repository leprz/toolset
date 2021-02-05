<?php

declare(strict_types=1);

namespace FilesystemStorage\Domain;

use FilesystemStorage\Domain\ValueObject\FileInterface;
use FilesystemStorage\Domain\ValueObject\RelativePathInterface;
use FilesystemStorage\Domain\ValueObject\UserAvatarImageInterface;
use FilesystemStorage\Domain\ValueObject\UserId;

interface ChangeAvatarServiceInterface
{
    /**
     * @param \FilesystemStorage\Domain\ValueObject\RelativePathInterface $avatar
     */
    public function removeAvatar(RelativePathInterface $avatar): void;

    /**
     * @param \FilesystemStorage\Domain\ValueObject\UserId $userId
     * @param \FilesystemStorage\Domain\ValueObject\FileInterface $avatarImage
     * @return \FilesystemStorage\Domain\ValueObject\UserAvatarImageInterface
     * @throws \FilesystemStorage\Domain\Exception\AvatarCanNotBeSavedException
     */
    public function saveAvatar(UserId $userId, FileInterface $avatarImage): UserAvatarImageInterface;
}
