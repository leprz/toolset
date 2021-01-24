<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage;

use FilesystemStorage\Application\FilesystemStorage;
use FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath;
use FilesystemStorage\Application\ValueObject\Url;

interface UserAvatarFilesystemStorageInterface extends AssetExistsInterface
{
    public function url(UserAvatarAssetPath $path): Url;
/**
     * Return file contents
     *
     * @param \FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath $path
     * @return string
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\FileReadException
     */
    public function load(UserAvatarAssetPath $path): string;
/**
     * @param string $filename
     * @param string $contents
     * @return \FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\AssetNotExistException
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\FileWriteException
     */
    public function save(string $filename, string $contents): UserAvatarAssetPath;
/**
     * @param \FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath $path
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\FileRemoveException
     */
    public function remove(UserAvatarAssetPath $path): void;
}
