<?php

declare(strict_types=1);

namespace FilesystemStorage\Infrastructure\FilesystemStorage\TenantConfig;

use FilesystemStorage\Application\Config\TenantConfig;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileReadException;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileRemoveException;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileWriteException;
use FilesystemStorage\Application\FilesystemStorage\TenantConfigFilesystemStorageInterface;
use FilesystemStorage\Application\ValueObject\Json;
use FilesystemStorage\Infrastructure\FilesystemStorage\LocalResourcePath;

class TenantConfigLocalFilesystemStorage implements TenantConfigFilesystemStorageInterface
{
    public const CONFIG_FILE_NAME = 'tenant_config.json';

    private string $configPath;

    private TenantConfigJsonMapper $mapper;

    public function __construct(LocalResourcePath $resourcesPath, TenantConfigJsonMapper $mapper)
    {
        $this->setConfigPath($resourcesPath);
        $this->mapper = $mapper;
    }

    private function setConfigPath(LocalResourcePath $resourcesPath): void
    {
        $this->configPath  = $resourcesPath . DIRECTORY_SEPARATOR . self::CONFIG_FILE_NAME;
    }

    public function load(): TenantConfig
    {
        if (false === ($contents = @file_get_contents($this->configPath))) {
            throw FileReadException::fromPath($this->configPath);
        }

        return $this->mapper->fromJson(Json::fromString($contents));
    }

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

    public function exists(): bool
    {
        return file_exists($this->configPath);
    }

    public function remove(): void
    {
        if (
            $this->exists() &&
            !@unlink($this->configPath)
        ) {
            throw FileRemoveException::fromPath($this->configPath);
        }
    }
}
