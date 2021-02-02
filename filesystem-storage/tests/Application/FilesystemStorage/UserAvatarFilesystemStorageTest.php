<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests\Application\FilesystemStorage;

use FilesystemStorage\Application\FilesystemStorage\AssetPath\UserAvatarAssetPath;
use FilesystemStorage\Application\ValueObject\RelativePath;
use FilesystemStorage\Domain\ValueObject\File;
use FilesystemStorage\Domain\ValueObject\UserId;
use FilesystemStorage\Infrastructure\FilesystemStorage\UserAvatar\UserAvatarLocalFilesystemStorage;
use FilesystemStorage\Tests\Application\UseCase\UserChangeAvatar\FakeUserAvatarFile;
use FilesystemStorage\Tests\KernelTestCase;

class UserAvatarFilesystemStorageTest extends KernelTestCase
{
    /**
     * @var \FilesystemStorage\Infrastructure\FilesystemStorage\UserAvatar\UserAvatarLocalFilesystemStorage
     */
    private UserAvatarLocalFilesystemStorage $storage;

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testSave(): void
    {
        $path = $this->storage->save($this->userIdFixture(), $this->userAvatarFileFixture());

        $this->assertAvatarFileExists($path->getRelativePath());
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    private function userIdFixture(): UserId
    {
        return UserId::fromString('30753a68-31bf-4af8-be5b-d5ca8bf5fbeb');
    }

    private function userAvatarFileFixture(): File
    {
        return new FakeUserAvatarFile();
    }

    private function assertAvatarFileExists(RelativePath $path): void
    {
        self::assertTrue($this->storage->exists($path));
    }

    /**
     * @depends testSave
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function testRemove(): void
    {
        $path = $this->userAvatarAssetPathFixture();
        $this->storage->remove($path);
        $this->assertAvatarHasBeenRemoved($path);
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    private function userAvatarAssetPathFixture(): UserAvatarAssetPath
    {
        return UserAvatarAssetPath::fromRelativePath(
            RelativePath::fromString('/avatars/' . $this->userIdFixture()),
            $this->storage
        );
    }

    private function assertAvatarHasBeenRemoved(UserAvatarAssetPath $path): void
    {
        self::assertFalse($this->storage->exists($path->getRelativePath()));
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testLoad(): void
    {
        $path = $this->storage->save($this->userIdFixture(), $this->userAvatarFileFixture());
        self::assertNotEmpty($this->storage->load($path));
    }

    protected function setUp(): void
    {
        self::bootKernel();
        $kernel = self::$kernel;
        $this->storage = new UserAvatarLocalFilesystemStorage($kernel->getResourcesDir());
    }
}
