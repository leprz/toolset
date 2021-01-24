<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\ValueObject;

use FilesystemStorage\Application\Exception\InvalidArgumentException;

final class RelativePath
{
    private string $path;
/**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private function __construct(string $path)
    {
        $this->setPath($path);
    }

    /**
     * @param $path
     * @return static
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public static function fromString($path): self
    {
        return new self($path);
    }

    /**
     * @param string $dir
     * @return $this
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public function append(string $dir): self
    {
        return new self($this->path . '/' . $dir);
    }

    /**
     * @param string $path
     * @return $this
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public function prependDir(string $path): self
    {
        return new self('/' . $path . $this->path);
    }

    public function baseDirEquals(self $baseDir): bool
    {
        return strpos($this->path, $baseDir->path) === 0;
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private function setPath(string $path): void
    {
        $path = self::unifyPath($path);
        self::assertPathFormat($path);
        $this->path = $path;
    }

    private static function unifyPath(string $path): string
    {
        $pathWithoutDuplicatedSlashes = preg_replace('/(\/+)/', '/', $path);
        return rtrim($pathWithoutDuplicatedSlashes, '/');
    }

    /**
     * @param $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertPathFormat($path): void
    {
        self::assertHasLeadingSlash($path);
        self::assertNotEndsWithDot($path);
        self::assertNoIllegalChars($path);
        self::assertHasOnlyOneFilename($path);
        self::assertFileIsAtLastPosition($path);
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertFileIsAtLastPosition(string $path): void
    {
        if (self::hasFilename($path)) {
            $pathChunks = explode('/', $path);
            $potentialFilename = end($pathChunks);
            if (!self::isFilename($potentialFilename)) {
                throw new InvalidArgumentException(sprintf('Path [%s] can not have filename in the middle', $path));
            }
        }
    }

    private static function hasFilename(string $filename): bool
    {
        return substr_count($filename, '.') > 0;
    }

    private static function isFilename(string $filename): bool
    {
        return substr_count($filename, '.') === 1;
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertHasOnlyOneFilename(string $path): void
    {
        if (substr_count($path, '.') > 1) {
            throw new InvalidArgumentException(sprintf('Path [%s] can only contain one filename', $path));
        }
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertNotEndsWithDot(string $path): void
    {
        if (strpos($path, '.', strlen($path) - 1) !== false) {
            throw new InvalidArgumentException(sprintf('Path [%s] can not end with comma "."', $path));
        }
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertNoIllegalChars(string $path): void
    {
        if (
            strpos($path, '..') !== false ||
            strpos($path, '*') !== false ||
            strpos($path, './') !== false ||
            strpos($path, '/.') !== false ||
            strpos($path, '\\') !== false
        ) {
            throw new InvalidArgumentException(
                sprintf('Path [%s] contain one of illegal characters [.., *, ./, /., \\]', $path)
            );
        }
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertHasLeadingSlash(string $path): void
    {
        if (strpos($path, '/') !== 0) {
            throw new InvalidArgumentException(sprintf('Path [%s] must starts with "/"', $path));
        }
    }

    public function __toString(): string
    {
        return $this->path;
    }
}
