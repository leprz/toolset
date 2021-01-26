<?php

declare(strict_types=1);

namespace FilesystemStorage\Infrastructure\FilesystemStorage;

use FilesystemStorage\Application\Exception\InvalidArgumentException;
use FilesystemStorage\Application\ValueObject\Utils\PathUtils;

class LocalPath
{
    private string $path;

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public function __construct(string $path)
    {
        $this->setPath($path);
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private function setPath(string $path): void
    {
        $path = PathUtils::fixIncorrectDirectorySeparators($path);
        $path = PathUtils::removeDuplicatedDirectorySeparators($path);
        $path = PathUtils::removeTrailingSlashes($path);

        self::assertHasOnlyOneFilename($path);
        self::assertNotEndsWithDot($path);

        if (PathUtils::hasFilename($path)) {
            self::assertFileIsAtLastPosition($path);
        }

        self::assertHasNoDirectorySwitchesOrWildcards($path);
        self::assertHasValidFormat($path);

        $this->path = $path;
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertHasOnlyOneFilename(string $path): void
    {
        if (!PathUtils::hasOnlyOneFilename($path)) {
            throw new InvalidArgumentException(sprintf('Path [%s] can only contain one filename', $path));
        }
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertNotEndsWithDot(string $path): void
    {
        if (PathUtils::hasTrailingDot($path)) {
            throw new InvalidArgumentException(sprintf('Path [%s] can not end with dot "."', $path));
        }
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertFileIsAtLastPosition(string $path): void
    {
        if (PathUtils::getFilename($path) === null) {
            throw new InvalidArgumentException(sprintf('Path [%s] can not have filename in the middle', $path));
        }
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertHasNoDirectorySwitchesOrWildcards(string $path): void
    {
        if (PathUtils::hasDirectorySwitchesOrWildcards($path)) {
            throw new InvalidArgumentException(
                sprintf('Path [%s] can not switch directories or use wildcards', $path)
            );
        }
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertHasValidFormat(string $path): void
    {
        if (!PathUtils::hasValidFormat($path)) {
            throw new InvalidArgumentException(
                sprintf('Path [%s] is invalid', $path)
            );
        }
    }

    /**
     * @param string $path
     * @return $this
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public function append(string $path): self
    {
        return new self($this->path . PathUtils::fixBoundaryDirectorySeparators($path));
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
