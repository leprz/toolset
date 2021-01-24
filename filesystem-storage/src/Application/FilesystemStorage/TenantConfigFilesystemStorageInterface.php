<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage;

use FilesystemStorage\Application\Config\TenantConfig;

/**
 * @package FilesystemStorage\Application\FilesystemStorage
 */
interface TenantConfigFilesystemStorageInterface
{
    /**
     * @return \FilesystemStorage\Application\Config\TenantConfig
     * @throws \FilesystemStorage\Application\Config\Exception\InvalidConfigException
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\FileReadException
     */
    public function load(): TenantConfig;

    /**
     * @param \FilesystemStorage\Application\Config\TenantConfig $config
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\FileWriteException
     */
    public function save(TenantConfig $config): void;

    /**
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\FileRemoveException
     */
    public function remove(): void;

    public function exists(): bool;
}
