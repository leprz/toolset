<?php

declare(strict_types=1);

namespace FilesystemStorage\Infrastructure\FilesystemStorage\UserAvatar;

use FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileReadException;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileRemoveException;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileWriteException;
use FilesystemStorage\Application\FilesystemStorage\UserAvatarFilesystemStorageInterface;
use FilesystemStorage\Application\ValueObject\RelativePath;
use FilesystemStorage\Domain\ValueObject\File;
use FilesystemStorage\Domain\ValueObject\UserId;
use FilesystemStorage\Infrastructure\FilesystemStorage\LocalResourcePath;

class UserAvatarLocalFilesystemStorage implements UserAvatarFilesystemStorageInterface
{
    private LocalResourcePath $resourcePath;

    public function __construct(LocalResourcePath $resourcesPath)
    {
        $this->setResourcePath($resourcesPath);
    }

    private function setResourcePath(LocalResourcePath $resourcesPath): void
    {
        $this->resourcePath = $resourcesPath;
    }

    public function load(UserAvatarAssetPath $path): string
    {
        if (false === ($contents = @file_get_contents($this->resourcePath . $path))) {
            throw FileReadException::fromPath((string)$path);
        }

        return $contents;
    }

    public function save(UserId $userId, File $file): UserAvatarAssetPath
    {
        $relativeDesignationPath = UserAvatarAssetPath::createRelativePathForFilename(
            sprintf('%s.%s', $userId, $file->getExtension())
        );

        $absoluteDestinationPath = $this->resourcePath->appendRelativePath($relativeDesignationPath);

        if (@file_put_contents((string)$absoluteDestinationPath, $file->getContents()) === false) {
            throw FileWriteException::fromPath((string)$absoluteDestinationPath);
        }

        return UserAvatarAssetPath::fromRelativePath($relativeDesignationPath, $this);
    }

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
     * @param \FilesystemStorage\Application\ValueObject\RelativePath $relativePath
     * @return bool
     */
    public function exists(RelativePath $relativePath): bool
    {
        return file_exists((string)$this->resourcePath->appendRelativePath($relativePath));
    }
}
