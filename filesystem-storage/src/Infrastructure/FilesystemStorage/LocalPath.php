<?php

declare(strict_types=1);

namespace FilesystemStorage\Infrastructure\FilesystemStorage;

class LocalPath
{
    private string $path;
/**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->setPath($path);
    }

    /**
     * @param string $path
     * @return $this
     */
    public function append(string $path): self
    {
        return new self($this->path . PathUtils::unifyTrailingSlashes($path));
    }

    /**
     * @param string $path
     */
    private function setPath(string $path): void
    {
        $this->path = PathUtils::unifyDirectorySeparators($path);
    }

    public function __toString(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    protected function getPath(): string
    {
        return $this->path;
    }
}
