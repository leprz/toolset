<?php
declare(strict_types=1);

namespace FilesystemStorage\Application\Persistence;

use FilesystemStorage\Domain\UserCard;
use FilesystemStorage\Domain\ValueObject\UserId;

interface UserCardRepositoryInterface
{
    public function getById(UserId $id): UserCard;
}
