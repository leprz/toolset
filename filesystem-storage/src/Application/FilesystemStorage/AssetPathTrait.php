<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\FilesystemStorage;

use FilesystemStorage\Application\Exception\InvalidArgumentException;
use FilesystemStorage\Application\FilesystemStorage\Exception\AssetNotExistException;
use FilesystemStorage\Application\ValueObject\RelativePath;

trait AssetPathTrait
{
    /**
     * @var \FilesystemStorage\Application\ValueObject\RelativePath
     */
    protected RelativePath $relativePath;

    /**
     * @param \FilesystemStorage\Application\ValueObject\RelativePath $relativePath
     * @param \FilesystemStorage\Application\FilesystemStorage\AssetExistsInterface $check
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\AssetNotExistException
     */
    protected function __construct(RelativePath $relativePath, AssetExistsInterface $check)
    {
        $this->setRelativePath($relativePath, $check);
    }

    /**
     * @param \FilesystemStorage\Application\ValueObject\RelativePath $relativePath
     * @param \FilesystemStorage\Application\FilesystemStorage\AssetExistsInterface $check
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\AssetNotExistException
     */
    private function setRelativePath(RelativePath $relativePath, AssetExistsInterface $check): void
    {
        self::assertIsInBaseDirectory($relativePath);
        self::assertFileExists($relativePath, $check);
        $this->relativePath = $relativePath;
    }

    /**
     * @param RelativePath $assetPath
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    private static function assertIsInBaseDirectory(RelativePath $assetPath): void
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
     * @return void
     * @throws \FilesystemStorage\Application\FilesystemStorage\Exception\AssetNotExistException
     */
    private static function assertFileExists(RelativePath $relativePath, AssetExistsInterface $storage): void
    {
        if (!$storage->exists($relativePath)) {
            throw AssetNotExistException::fromPath((string) $relativePath);
        }
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
