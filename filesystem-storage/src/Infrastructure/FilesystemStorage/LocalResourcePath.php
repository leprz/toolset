<?php

declare(strict_types=1);

namespace FilesystemStorage\Infrastructure\FilesystemStorage;

use FilesystemStorage\Application\ValueObject\RelativePath;

class LocalResourcePath extends LocalPath
{
    protected function __construct(string $path)
    {
        parent::__construct($path);
    }

    /**
     * @param \FilesystemStorage\Application\ValueObject\RelativePath $path
     * @return $this
     */
    public function appendRelativePath(RelativePath $path): self
    {
        return new self($this->getPath() . $path);
    }
}
