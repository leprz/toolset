<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\UseCase\UserChangeAvatar;

use FilesystemStorage\Domain\ChangeAvatarDataInterface;
use FilesystemStorage\Domain\ValueObject\FileInterface;
use FilesystemStorage\Domain\ValueObject\UserId;

class UserChangeAvatarCommand implements ChangeAvatarDataInterface
{
    /**
     * @var \FilesystemStorage\Domain\ValueObject\UserId
     */
    private UserId $userId;

    /**
     * @var \FilesystemStorage\Domain\ValueObject\FileInterface
     */
    private FileInterface $avatarImage;

    /**
     * @param \FilesystemStorage\Domain\ValueObject\UserId $userId
     * @param \FilesystemStorage\Domain\ValueObject\FileInterface $avatarImage
     */
    public function __construct(UserId $userId, FileInterface $avatarImage)
    {
        $this->userId = $userId;
        $this->avatarImage = $avatarImage;
    }


    public function getAvatarImage(): FileInterface
    {
        return $this->avatarImage;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
