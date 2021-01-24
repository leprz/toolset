<?php

declare(strict_types=1);

namespace FilesystemStorage\Infrastructure\FilesystemStorage\TenantConfig;

use FilesystemStorage\Application\Config\Exception\InvalidConfigException;
use FilesystemStorage\Application\Config\TenantConfig;
use FilesystemStorage\Application\ValueObject\Json;

class TenantConfigJsonMapper
{
    public function toJson(TenantConfig $config): Json
    {
        return Json::fromArray([
                'name' => $config->getName(),
                'capacity' => $config->getCapacity()
            ]);
    }

    /**
     * @param \FilesystemStorage\Application\ValueObject\Json $json
     * @return \FilesystemStorage\Application\Config\TenantConfig
     * @throws \FilesystemStorage\Application\Config\Exception\InvalidConfigException
     */
    public function fromJson(Json $json): TenantConfig
    {
        $data = $json->toArray();
        $this->validateData($data);
        return new TenantConfig($data['name'], $data['capacity']);
    }

    /**
     * @param array $data
     * @throws \FilesystemStorage\Application\Config\Exception\InvalidConfigException
     */
    private function validateData(array $data): void
    {
        $requiredProperties = ['name', 'capacity',];
        $invalidConfigException = new InvalidConfigException(TenantConfigLocalFilesystemStorage::CONFIG_FILE_NAME);
        $isValid = true;
        foreach ($requiredProperties as $requiredPropertyName) {
            if (!array_key_exists($requiredPropertyName, $data)) {
                $invalidConfigException->addMissingProperty($requiredPropertyName);
                $isValid = false;
            }
        }

        if (!$isValid) {
            throw $invalidConfigException;
        }
    }
}
