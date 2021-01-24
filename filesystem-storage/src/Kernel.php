<?php

declare(strict_types=1);

namespace FilesystemStorage;

use FilesystemStorage\Application\Exception\InvalidArgumentException;
use FilesystemStorage\Infrastructure\FilesystemStorage\LocalResourcePath;

class Kernel
{
    protected LocalResourcePath $resourcesPath;

    /**
     * @param string $resourcesPath
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public function __construct(string $resourcesPath)
    {
        $this->setResourcesDir(new class ($resourcesPath) extends LocalResourcePath {
            public function __construct(string $path)
            {
                parent::__construct($path);
            }
        });
    }

    public function getResourcesDir(): LocalResourcePath
    {
        return $this->resourcesPath;
    }

    /**
     * @param \FilesystemStorage\Infrastructure\FilesystemStorage\LocalResourcePath $resourcesPath
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    protected function setResourcesDir(LocalResourcePath $resourcesPath): void
    {
        if (!is_dir((string) $resourcesPath)) {
            throw new InvalidArgumentException(
                sprintf('Resource path [%s] must be existing directory.', (string) $resourcesPath)
            );
        }

        if (!realpath((string) $resourcesPath)) {
            throw new InvalidArgumentException(
                sprintf('Resource path [%s] does not exists.', (string) $resourcesPath)
            );
        }

        $this->resourcesPath = $resourcesPath;
    }
}
