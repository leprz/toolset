<?php
declare(strict_types=1);

namespace FilesystemStorage\Application\UseCase\UserChangeAvatar;

use FilesystemStorage\Application\Persistence\UserCardRepositoryInterface;
use FilesystemStorage\Domain\ChangeAvatarServiceInterface;
use FilesystemStorage\Domain\Exception\AvatarCanNotBeSavedException;

class UserChangeAvatarHandler
{
    /**
     * @var \FilesystemStorage\Application\Persistence\UserCardRepositoryInterface
     */
    private UserCardRepositoryInterface $userCardRepository;

    /**
     * @var \FilesystemStorage\Domain\ChangeAvatarServiceInterface
     */
    private ChangeAvatarServiceInterface $avatarService;

    /**
     * @param \FilesystemStorage\Application\Persistence\UserCardRepositoryInterface $userCardRepository
     * @param \FilesystemStorage\Domain\ChangeAvatarServiceInterface $avatarService
     */
    public function __construct(
        UserCardRepositoryInterface $userCardRepository,
        ChangeAvatarServiceInterface $avatarService
    ) {
        $this->userCardRepository = $userCardRepository;
        $this->avatarService = $avatarService;
    }

    /**
     * @param \FilesystemStorage\Application\UseCase\UserChangeAvatar\UserChangeAvatarCommand $command
     */
    public function __invoke(UserChangeAvatarCommand $command)
    {
        $userCard = $this->userCardRepository->getById($command->getUserId());

        try {
            $userCard->changeAvatar($command, $this->avatarService);
        } catch (AvatarCanNotBeSavedException $e) {
            // Handle somehow
        }

        // save
    }
}
