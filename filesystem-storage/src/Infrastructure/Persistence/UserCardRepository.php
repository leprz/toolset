<?php

declare(strict_types=1);

namespace FilesystemStorage\Infrastructure\Persistence;

use FilesystemStorage\Application\Persistence\UserCardRepositoryInterface;
use FilesystemStorage\Domain\UserCard;
use FilesystemStorage\Domain\ValueObject\UserId;

class UserCardRepository implements UserCardRepositoryInterface
{
    /**
     * @param \FilesystemStorage\Domain\ValueObject\UserId $id
     * @return \FilesystemStorage\Domain\UserCard
     */
    public function getById(UserId $id): UserCard
    {
        // This is just a fake repository not relevant in this example
        return new UserCard($id);
    }
}
