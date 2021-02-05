<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\ValueObject;

use FilesystemStorage\Application\Exception\InvalidArgumentException;
use FilesystemStorage\Application\ValueObject\Utils\PathUtils;
use FilesystemStorage\Domain\ValueObject\RelativePathInterface;

class RelativePath implements RelativePathInterface
{
    /**
     * @var string
     */
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
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private function setPath(string $path): void
    {
        $path = self::fixPath($path);
        self::assertPathFormat($path);
        $this->path = $path;
    }

    /**
     * @param string $path
     * @return string
     */
    private static function fixPath(string $path): string
    {
        return PathUtils::removeTrailingSlashes(
            PathUtils::removeDuplicatedForwardSlashes($path)
        );
    }

    /**
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertPathFormat(string $path): void
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
    private static function assertHasLeadingSlash(string $path): void
    {
        if (strpos($path, '/') !== 0) {
            throw new InvalidArgumentException(sprintf('Path [%s] must starts with "/"', $path));
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
    private static function assertNoIllegalChars(string $path): void
    {
        if (PathUtils::hasDirectorySwitchesOrWildcards($path) === true || strpos($path, '\\') !== false) {
            throw new InvalidArgumentException(
                sprintf('Path [%s] contain one of illegal characters [.., *, ./, /., \\]', $path)
            );
        }
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
    private static function assertFileIsAtLastPosition(string $path): void
    {
        if (PathUtils::hasFilename($path)) {
            $pathChunks = explode('/', $path);
            $potentialFilename = end($pathChunks);
            if (!PathUtils::isFilename($potentialFilename)) {
                throw new InvalidArgumentException(sprintf('Path [%s] can not have filename in the middle', $path));
            }
        }
    }

    /**
     * @param $path
     * @return self
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public static function fromString(string $path): self
    {
        return new self($path);
    }

    /**
     * @param string $dir
     * @return self
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public function append(string $dir): self
    {
        return new self($this->path . '/' . $dir);
    }

    /**
     * @param string $path
     * @return self
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
     * @return string
     */
    public function __toString(): string
    {
        return $this->path;
    }
}
