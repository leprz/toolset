<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage\TenantConfig;

use FilesystemStorage\Application\Config\TenantConfig;

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

    /**
     * @return bool
     */
    public function exists(): bool;
}
