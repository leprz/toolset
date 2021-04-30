<?php
declare(strict_types=1);

namespace SharedKernel\Application\ValueObject;

use InvalidArgumentException;
use function str_contains;
use function str_starts_with;

trait RelativePathTrait
{
    /**
     * @var string
     */
    private string $path;

    /**
     * @param string $path
     */
    private function __construct(string $path)
    {
        $this->setPath($path);
    }

    /**
     * @param string $path
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
        return RelativePathUtils::removeTrailingSlashes(
            RelativePathUtils::removeDuplicatedForwardSlashes($path)
        );
    }

    /**
     * @param string $path
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
     */
    private static function assertHasLeadingSlash(string $path): void
    {
        if (!str_starts_with($path, '/')) {
            throw new InvalidArgumentException(sprintf('Path [%s] must starts with "/"', $path));
        }
    }

    /**
     * @param string $path
     */
    private static function assertNotEndsWithDot(string $path): void
    {
        if (RelativePathUtils::hasTrailingDot($path)) {
            throw new InvalidArgumentException(sprintf('Path [%s] can not end with dot "."', $path));
        }
    }

    /**
     * @param string $path
     */
    private static function assertNoIllegalChars(string $path): void
    {
        if (RelativePathUtils::hasDirectorySwitchesOrWildcards($path) === true || str_contains($path, '\\')) {
            throw new InvalidArgumentException(
                sprintf('Path [%s] contain one of illegal characters [.., *, ./, /., \\]', $path)
            );
        }
    }

    /**
     * @param string $path
     */
    private static function assertHasOnlyOneFilename(string $path): void
    {
        if (!RelativePathUtils::hasOnlyOneFilename($path)) {
            throw new InvalidArgumentException(sprintf('Path [%s] can only contain one filename', $path));
        }
    }

    /**
     * @param string $path
     */
    private static function assertFileIsAtLastPosition(string $path): void
    {
        if (RelativePathUtils::hasFilename($path)) {
            $pathChunks = explode('/', $path);
            $potentialFilename = end($pathChunks);
            if (!RelativePathUtils::isFilename($potentialFilename)) {
                throw new InvalidArgumentException(sprintf('Path [%s] can not have filename in the middle', $path));
            }
        }
    }

    /**
     * @param $path
     * @return self
     */
    public static function fromString(string $path): self
    {
        return new self($path);
    }

    /**
     * @param string $dir
     * @return self
     */
    public function append(string $dir): self
    {
        return new self($this->path . '/' . $dir);
    }

    /**
     * @param string $path
     * @return self
     */
    public function prependDir(string $path): self
    {
        return new self('/' . $path . $this->path);
    }

    public function baseDirEquals(self $baseDir): bool
    {
        return str_starts_with($this->path, $baseDir->path);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->path;
    }
}
