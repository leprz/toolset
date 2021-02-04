<?php

declare(strict_types=1);

namespace FilesystemStorage\Infrastructure\FilesystemStorage\TenantConfig;

use FilesystemStorage\Application\Config\TenantConfig;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileReadException;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileRemoveException;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileWriteException;
use FilesystemStorage\Application\FilesystemStorage\TenantConfig\TenantConfigFilesystemStorageInterface;
use FilesystemStorage\Application\ValueObject\Json;
use FilesystemStorage\Infrastructure\FilesystemStorage\LocalResourcePath;

class TenantConfigLocalFilesystemStorage implements TenantConfigFilesystemStorageInterface
{
    public const CONFIG_FILE_NAME = 'tenant_config.json';

    /**
     * @var string
     */
    private string $configPath;

    /**
     * @var \FilesystemStorage\Infrastructure\FilesystemStorage\TenantConfig\TenantConfigJsonMapper
     */
    private TenantConfigJsonMapper $mapper;

    /**
     * @param \FilesystemStorage\Infrastructure\FilesystemStorage\LocalResourcePath $resourcesPath
     * @param \FilesystemStorage\Infrastructure\FilesystemStorage\TenantConfig\TenantConfigJsonMapper $mapper
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public function __construct(LocalResourcePath $resourcesPath, TenantConfigJsonMapper $mapper)
    {
        $this->setConfigPath($resourcesPath);
        $this->mapper = $mapper;
    }

    /**
     * @param \FilesystemStorage\Infrastructure\FilesystemStorage\LocalResourcePath $resourcesPath
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private function setConfigPath(LocalResourcePath $resourcesPath): void
    {
        $this->configPath = (string)$resourcesPath->append(self::CONFIG_FILE_NAME);
    }

    /**
     * @inheritDoc
     */
    public function load(): TenantConfig
    {
        if (false === ($contents = @file_get_contents($this->configPath))) {
            throw FileReadException::fromPath($this->configPath);
        }

        return $this->mapper->fromJson(Json::fromString($contents));
    }

    /**
     * @inheritDoc
     */
    public function save(TenantConfig $config): void
    {
        if (
            @file_put_contents(
                $this->configPath,
                (string)$this->mapper->toJson($config)
            ) === false
        ) {
            throw FileWriteException::fromPath($this->configPath);
        }
    }

    /**
     * @inheritDoc
     */
    public function remove(): void
    {
        if (
            $this->exists() &&
            !@unlink($this->configPath)
        ) {
            throw FileRemoveException::fromPath($this->configPath);
        }
    }

    /**
     * @inheritDoc
     */
    public function exists(): bool
    {
        return file_exists($this->configPath);
    }
}
