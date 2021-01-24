<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests\Application\FilesystemStorage\AssetPath;

use FilesystemStorage\Application\Exception\InvalidArgumentException;
use FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath;
use FilesystemStorage\Application\FilesystemStorage\UserAvatarFilesystemStorageInterface;
use FilesystemStorage\Application\ValueObject\RelativePath;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserAvatarAssetPathTest extends TestCase
{
    /**
     * @var \FilesystemStorage\Application\FilesystemStorage\UserAvatarFilesystemStorageInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private MockObject $storageMock;
    public function testCreateRelativePathForFileName(): void
    {
        self::assertEquals('/avatars/test.jpg', UserAvatarAssetPath::createRelativePathForFilename('test.jpg'));
    }

    public function testFromRelativePath(): void
    {
        $this->assertPathEqualsTo(
            '/avatars/test.jpg',
            UserAvatarAssetPath::fromRelativePath(
                RelativePath::fromString('/avatars/test.jpg'),
                $this->storageMock
            )
        );
    }

    public function testWrongBasePath(): void
    {
        $this->assertAvatarPathIsInvalid();
        UserAvatarAssetPath::fromRelativePath(RelativePath::fromString('/wrong/basename.txt'), $this->storageMock);
    }

    public function assertAvatarPathIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
    }

    private function assertPathEqualsTo(string $expected, UserAvatarAssetPath $assetPath): void
    {
        self::assertEquals($expected, (string) $assetPath);
    }

    protected function setUp(): void
    {
        $this->storageMock = $this->createMock(UserAvatarFilesystemStorageInterface::class);
        $this->storageMock->method('exists')->willReturn(true);
    }
}
