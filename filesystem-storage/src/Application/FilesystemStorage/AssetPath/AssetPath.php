<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage\AssetPath;

use FilesystemStorage\Application\Exception\InvalidArgumentException;
use FilesystemStorage\Application\FilesystemStorage\AssetExistsInterface;
use FilesystemStorage\Application\ValueObject\RelativePath;

abstract class AssetPath
{
    /**
     * @var \FilesystemStorage\Application\ValueObject\RelativePath
     */
    protected RelativePath $relativePath;

    /**
     * @param \FilesystemStorage\Application\ValueObject\RelativePath $relativePath
     * @param \FilesystemStorage\Application\FilesystemStorage\AssetExistsInterface $check
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    protected function __construct(RelativePath $relativePath, AssetExistsInterface $check)
    {
        $this->setRelativePath($relativePath, $check);
    }

    /**
     * @param \FilesystemStorage\Application\ValueObject\RelativePath $relativePath
     * @param \FilesystemStorage\Application\FilesystemStorage\AssetExistsInterface $check
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private function setRelativePath(RelativePath $relativePath, AssetExistsInterface $check): void
    {
        self::assertBaseDirectory($relativePath);
        self::assertFileExists($relativePath, $check);
        $this->relativePath = $relativePath;
    }

    /**
     * @param RelativePath $assetPath
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertBaseDirectory(RelativePath $assetPath): void
    {
        if (!$assetPath->baseDirEquals(static::baseDirectory())) {
            throw new InvalidArgumentException(
                sprintf(
                    'Asset [%s] must be in "%s" directory ',
                    (string)$assetPath,
                    (string)static::baseDirectory()
                )
            );
        }
    }

    /**
     * @return \FilesystemStorage\Application\ValueObject\RelativePath
     */
    abstract protected static function baseDirectory(): RelativePath;

    /**
     * @param \FilesystemStorage\Application\ValueObject\RelativePath $relativePath
     * @param \FilesystemStorage\Application\FilesystemStorage\AssetExistsInterface $storage
     * @return bool
     */
    private static function assertFileExists(RelativePath $relativePath, AssetExistsInterface $storage): bool
    {
        return $storage->exists($relativePath);
    }

    /**
     * @return \FilesystemStorage\Application\ValueObject\RelativePath
     */
    public function getRelativePath(): RelativePath
    {
        return $this->relativePath;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->relativePath;
    }
}
