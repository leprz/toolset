<?php
declare(strict_types=1);

namespace FilesystemStorage\Application\UseCase\UserChangeAvatar;

use FilesystemStorage\Application\Exception\InvalidArgumentException;
use FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath;
use FilesystemStorage\Application\FilesystemStorage\Exception\AssetNotExistException;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileRemoveException;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileWriteException;
use FilesystemStorage\Application\FilesystemStorage\UserAvatarFilesystemStorageInterface;
use FilesystemStorage\Application\ValueObject\RelativePath;
use FilesystemStorage\Domain\ChangeAvatarServiceInterface;
use FilesystemStorage\Domain\Exception\AvatarCanNotBeSavedException;
use FilesystemStorage\Domain\ValueObject\File;
use FilesystemStorage\Domain\ValueObject\UserAvatarImage;
use FilesystemStorage\Domain\ValueObject\UserId;

class ChangeAvatarService implements ChangeAvatarServiceInterface
{
    /**
     * @var \FilesystemStorage\Application\FilesystemStorage\UserAvatarFilesystemStorageInterface
     */
    private UserAvatarFilesystemStorageInterface $avatarStorage;

    public function __construct(UserAvatarFilesystemStorageInterface $avatarStorage)
    {
        $this->avatarStorage = $avatarStorage;
    }

    /**
     * @inheritDoc
     */
    public function removeAvatar(UserAvatarImage $avatar): void
    {
        try {
            $this->avatarStorage->remove(
                UserAvatarAssetPath::fromRelativePath(
                    RelativePath::fromString((string)$avatar),
                    $this->avatarStorage
                )
            );
        } catch (InvalidArgumentException $e) {
        } catch (FileRemoveException $e) {
            // Log it somewhere
        }
    }

    /**
     * @inheritDoc
     */
    public function saveAvatar(UserId $userId, File $avatarImage): UserAvatarImage
    {
        try {
            return $this->avatarStorage->save((string)$userId, $avatarImage->getContents());
        } catch (InvalidArgumentException $e) {
        } catch (AssetNotExistException $e) {
        } catch (FileWriteException $e) {
            throw new AvatarCanNotBeSavedException($e->getMessage());
        }
    }
}
