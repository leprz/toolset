<?php
declare(strict_types=1);

namespace FilesystemStorage\Domain;

use FilesystemStorage\Domain\ValueObject\File;
use FilesystemStorage\Domain\ValueObject\UserAvatarImage;
use FilesystemStorage\Domain\ValueObject\UserId;

interface ChangeAvatarServiceInterface
{
    /**
     * @param \FilesystemStorage\Domain\ValueObject\UserAvatarImage $avatar
     */
    public function removeAvatar(UserAvatarImage $avatar): void;

    /**
     * @param \FilesystemStorage\Domain\ValueObject\UserId $userId
     * @param \FilesystemStorage\Domain\ValueObject\File $avatarImage
     * @return \FilesystemStorage\Domain\ValueObject\UserAvatarImage
     * @throws \FilesystemStorage\Domain\Exception\AvatarCanNotBeSavedException
     */
    public function saveAvatar(UserId $userId, File $avatarImage): UserAvatarImage;
}
