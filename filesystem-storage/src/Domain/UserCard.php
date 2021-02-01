<?php
declare(strict_types=1);

namespace FilesystemStorage\Domain;

use FilesystemStorage\Domain\ValueObject\File;
use FilesystemStorage\Domain\ValueObject\UserAvatarImage;
use FilesystemStorage\Domain\ValueObject\UserId;

class UserCard
{
    /**
     * @var \FilesystemStorage\Domain\ValueObject\UserId
     */
    private UserId $id;

    /**
     * @var \FilesystemStorage\Domain\ValueObject\UserAvatarImage|null
     */
    private ?UserAvatarImage $avatar = null;

    /**
     * @param \FilesystemStorage\Domain\ValueObject\File $avatarImage
     * @param \FilesystemStorage\Domain\ChangeAvatarServiceInterface $service
     * @throws \FilesystemStorage\Domain\Exception\AvatarCanNotBeSavedException
     */
    public function changeAvatar(File $avatarImage, ChangeAvatarServiceInterface $service): void
    {
        if ($oldAvatar = $this->avatar) {
            $service->removeAvatar($oldAvatar);
        }

        $newAvatar = $service->saveAvatar($this->id, $avatarImage);

        $this->avatar = $newAvatar;
    }
}
