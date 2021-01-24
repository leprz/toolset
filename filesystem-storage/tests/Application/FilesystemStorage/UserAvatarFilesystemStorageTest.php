<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests\Application\FilesystemStorage;

use FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath;
use FilesystemStorage\Application\FilesystemStorage\Exception\FileWriteException;
use FilesystemStorage\Application\ValueObject\RelativePath;
use FilesystemStorage\Infrastructure\FilesystemStorage\UserAvatar\UserAvatarLocalFilesystemStorage;
use FilesystemStorage\Tests\KernelTestCase;

class UserAvatarFilesystemStorageTest extends KernelTestCase
{
    /**
     * @var \FilesystemStorage\Infrastructure\FilesystemStorage\UserAvatar\UserAvatarLocalFilesystemStorage
     */
    private UserAvatarLocalFilesystemStorage $storage;
    public function testSave(): void
    {
        $path = $this->storage->save($this->userAvatarFilenameFixture(), $this->userAvatarContentsFixture());
        $this->assertAvatarFileExists($path->getRelativePath());
    }

    private function userAvatarContentsFixture(): string
    {
        return file_get_contents(__DIR__ . '/assets/robot.png');
    }

    private function assertAvatarFileExists(RelativePath $path): void
    {
        self::assertTrue($this->storage->exists($path));
    }

    /**
     * @depends testSave
     */
    public function testRemove(): void
    {
        $path = $this->userAvatarAssetPathFixture();
        $this->storage->remove($path);
        $this->assertAvatarHasBeenRemoved($path);
    }

    private function userAvatarAssetPathFixture(): UserAvatarAssetPath
    {
        return UserAvatarAssetPath::fromRelativePath(
            RelativePath::fromString('/avatars/' . $this->userAvatarFilenameFixture()),
            $this->storage
        );
    }

    private function userAvatarFilenameFixture(): string
    {
        return 'test-avatar.png';
    }

    private function assertAvatarHasBeenRemoved(UserAvatarAssetPath $path): void
    {
        self::assertFalse($this->storage->exists($path->getRelativePath()));
    }

    public function testLoad(): void
    {
        $path = $this->storage->save($this->userAvatarFilenameFixture(), $this->userAvatarContentsFixture());
        self::assertNotEmpty($this->storage->load($path));
    }

    public function testSaveWithNonExistingDirectory(): void
    {
        $this->assertFileCanNotBeWritten();
        $this->storage->save('wrong-dir/test.png', $this->userAvatarContentsFixture());
    }

    private function assertFileCanNotBeWritten(): void
    {
        $this->expectException(FileWriteException::class);
    }

    protected function setUp(): void
    {
        self::bootKernel();
        $kernel = self::$kernel;
        $this->storage = new UserAvatarLocalFilesystemStorage($kernel->getResourcesDir());
    }
}
