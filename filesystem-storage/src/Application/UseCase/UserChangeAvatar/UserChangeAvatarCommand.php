<?php
declare(strict_types=1);

namespace FilesystemStorage\Application\UseCase\UserChangeAvatar;

use FilesystemStorage\Domain\ChangeAvatarDataInterface;
use FilesystemStorage\Domain\ValueObject\File;
use FilesystemStorage\Domain\ValueObject\UserId;

class UserChangeAvatarCommand implements ChangeAvatarDataInterface
{
    private UserId $userId;

    private File $avatarImage;

    public function __construct(UserId $userId, File $avatarImage)
    {
        $this->userId = $userId;
        $this->avatarImage = $avatarImage;
    }

    public function getAvatarImage(): File
    {
        return $this->avatarImage;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
