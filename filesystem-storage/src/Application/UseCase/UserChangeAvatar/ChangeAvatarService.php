<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\UseCase\UserChangeAvatar;

use FilesystemStorage\Application\Exception\InvalidArgumentException;
use FilesystemStorage\Application\FilesystemStorage\Exception\AssetNotExistException;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileRemoveException;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileWriteException;
use FilesystemStorage\Application\FilesystemStorage\UserAvatar\UserAvatarAssetPath;
use FilesystemStorage\Application\FilesystemStorage\UserAvatar\UserAvatarFilesystemStorageInterface;
use FilesystemStorage\Application\ValueObject\RelativePath;
use FilesystemStorage\Domain\ChangeAvatarServiceInterface;
use FilesystemStorage\Domain\Exception\AvatarCanNotBeSavedException;
use FilesystemStorage\Domain\ValueObject\FileInterface;
use FilesystemStorage\Domain\ValueObject\RelativePathInterface;
use FilesystemStorage\Domain\ValueObject\UserAvatarImageInterface;
use FilesystemStorage\Domain\ValueObject\UserId;

class ChangeAvatarService implements ChangeAvatarServiceInterface
{
    /**
     * @var \FilesystemStorage\Application\FilesystemStorage\UserAvatar\UserAvatarFilesystemStorageInterface
     */
    private UserAvatarFilesystemStorageInterface $avatarStorage;

    public function __construct(UserAvatarFilesystemStorageInterface $avatarStorage)
    {
        $this->avatarStorage = $avatarStorage;
    }

    /**
     * @inheritDoc
     */
    public function removeAvatar(RelativePathInterface $avatar): void
    {
        try {
            $this->avatarStorage->remove(
                UserAvatarAssetPath::fromRelativePath(
                    RelativePath::fromString((string)$avatar),
                    $this->avatarStorage
                )
            );
        } catch (FileRemoveException | InvalidArgumentException | AssetNotExistException $e) {
            // Log it somewhere
        }
    }

    /**
     * @inheritDoc
     */
    public function saveAvatar(UserId $userId, FileInterface $avatarImage): UserAvatarImageInterface
    {
        try {
            return $this->avatarStorage->save($userId, $avatarImage);
        } catch (InvalidArgumentException | FileWriteException $e) {
            throw new AvatarCanNotBeSavedException($e->getMessage());
        }
    }
}
