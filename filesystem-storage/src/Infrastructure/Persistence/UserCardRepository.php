<?php
declare(strict_types=1);

namespace FilesystemStorage\Infrastructure\Persistence;

use FilesystemStorage\Application\Persistence\UserCardRepositoryInterface;
use FilesystemStorage\Domain\UserCard;
use FilesystemStorage\Domain\ValueObject\UserId;

class UserCardRepository implements UserCardRepositoryInterface
{
    public function getById(UserId $id): UserCard
    {
        // This is just a fake repository not relevant in this example
        return new class ($id) extends UserCard {
            public function __construct(UserId $id)
            {
                $this->setId($id);
            }
        };
    }
}
