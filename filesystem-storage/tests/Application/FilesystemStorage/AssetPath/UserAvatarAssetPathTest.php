<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests\Application\FilesystemStorage\AssetPath;

use FilesystemStorage\Application\Exception\InvalidArgumentException;
use FilesystemStorage\Application\FilesystemStorage\UserAvatar\UserAvatarAssetPath;
use FilesystemStorage\Application\FilesystemStorage\UserAvatar\UserAvatarFilesystemStorageInterface;
use FilesystemStorage\Application\ValueObject\RelativePath;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserAvatarAssetPathTest extends TestCase
{
    /**
     * @var \FilesystemStorage\Application\FilesystemStorage\UserAvatar\UserAvatarFilesystemStorageInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private MockObject $storageMock;

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testCreateRelativePathForFileName(): void
    {
        self::assertEquals(
            '/avatars/test.jpg',
            UserAvatarAssetPath::createRelativePathForFilename('test.jpg')
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
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

    private function assertPathEqualsTo(string $expected, UserAvatarAssetPath $assetPath): void
    {
        self::assertEquals($expected, (string)$assetPath);
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testWrongBasePath(): void
    {
        $this->assertAvatarPathIsInvalid();
        UserAvatarAssetPath::fromRelativePath(RelativePath::fromString('/wrong/basename.txt'), $this->storageMock);
    }

    public function assertAvatarPathIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
    }

    protected function setUp(): void
    {
        $this->storageMock = $this->createMock(UserAvatarFilesystemStorageInterface::class);
        $this->storageMock->method('exists')->willReturn(true);
    }
}
