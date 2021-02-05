<?php

declare(strict_types=1);

namespace FilesystemStorage\Infrastructure\FilesystemStorage\UserAvatar;

use FilesystemStorage\Application\FilesystemStorage\Exception\AssetNotExistException;
use FilesystemStorage\Application\FilesystemStorage\UserAvatar\UserAvatarAssetPath;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileReadException;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileRemoveException;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileWriteException;
use FilesystemStorage\Application\FilesystemStorage\UserAvatar\UserAvatarFilesystemStorageInterface;
use FilesystemStorage\Application\ValueObject\RelativePath;
use FilesystemStorage\Domain\ValueObject\FileInterface;
use FilesystemStorage\Domain\ValueObject\UserId;
use FilesystemStorage\Infrastructure\FilesystemStorage\LocalResourcePath;

class UserAvatarLocalFilesystemStorage implements UserAvatarFilesystemStorageInterface
{
    /**
     * @var \FilesystemStorage\Infrastructure\FilesystemStorage\LocalResourcePath
     */
    private LocalResourcePath $resourcePath;

    /**
     * @param \FilesystemStorage\Infrastructure\FilesystemStorage\LocalResourcePath $resourcesPath
     */
    public function __construct(LocalResourcePath $resourcesPath)
    {
        $this->setResourcePath($resourcesPath);
    }

    /**
     * @param \FilesystemStorage\Infrastructure\FilesystemStorage\LocalResourcePath $resourcesPath
     */
    private function setResourcePath(LocalResourcePath $resourcesPath): void
    {
        $this->resourcePath = $resourcesPath;
    }

    /**
     * @inheritDoc
     */
    public function load(UserAvatarAssetPath $path): string
    {
        if (false === ($contents = @file_get_contents($this->resourcePath . $path))) {
            throw FileReadException::fromPath((string)$path);
        }

        return $contents;
    }

    /**
     * @inheritDoc
     */
    public function save(UserId $userId, FileInterface $file): UserAvatarAssetPath
    {
        $relativeDesignationPath = UserAvatarAssetPath::createRelativePathForFilename(
            sprintf('%s.%s', (string) $userId, $file->getExtension())
        );

        $absoluteDestinationPath = $this->resourcePath->appendRelativePath($relativeDesignationPath);

        if (@file_put_contents((string)$absoluteDestinationPath, $file->getContents()) === false) {
            throw FileWriteException::fromPath((string)$absoluteDestinationPath);
        }

        try {
            return UserAvatarAssetPath::fromRelativePath($relativeDesignationPath, $this);
        } catch (AssetNotExistException $e) {
            throw new FileWriteException('File has not been saved');
        }
    }

    /**
     * @inheritDoc
     */
    public function remove(UserAvatarAssetPath $path): void
    {
        if (
            $this->exists($path->getRelativePath()) &&
            !@unlink((string)$this->resourcePath->appendRelativePath($path->getRelativePath()))
        ) {
            throw FileRemoveException::fromPath((string)$path);
        }
    }

    /**
     * @inheritDoc
     */
    public function exists(RelativePath $relativePath): bool
    {
        return file_exists((string)$this->resourcePath->appendRelativePath($relativePath));
    }
}
