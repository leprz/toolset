<?php
declare(strict_types=1);

namespace FilesystemStorage\Domain;

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
     * @param \FilesystemStorage\Domain\ChangeAvatarDataInterface $data
     * @param \FilesystemStorage\Domain\ChangeAvatarServiceInterface $service
     * @throws \FilesystemStorage\Domain\Exception\AvatarCanNotBeSavedException
     */
    public function changeAvatar(ChangeAvatarDataInterface $data, ChangeAvatarServiceInterface $service): void
    {
        if ($oldAvatar = $this->avatar) {
            $service->removeAvatar($oldAvatar);
        }

        $newAvatar = $service->saveAvatar($this->id, $data->getAvatarImage());

        $this->avatar = $newAvatar;
    }

    /**
     * @param \FilesystemStorage\Domain\ValueObject\UserId $id
     */
    protected function setId(UserId $id): void
    {
        $this->id = $id;
    }
}
