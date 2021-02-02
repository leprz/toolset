<?php
declare(strict_types=1);

namespace FilesystemStorage\Tests\Application\UseCase\UserChangeAvatar;

use FilesystemStorage\Application\FilesystemStorage\UserAvatarFilesystemStorageInterface;
use FilesystemStorage\Application\UseCase\UserChangeAvatar\ChangeAvatarService;
use FilesystemStorage\Application\UseCase\UserChangeAvatar\UserChangeAvatarCommand;
use FilesystemStorage\Application\UseCase\UserChangeAvatar\UserChangeAvatarHandler;
use FilesystemStorage\Domain\ValueObject\UserId;
use FilesystemStorage\Infrastructure\Persistence\UserCardRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserChangeAvatarTest extends TestCase
{
    /**
     * @var \FilesystemStorage\Application\UseCase\UserChangeAvatar\UserChangeAvatarHandler
     */
    private UserChangeAvatarHandler $useCase;
    /**
     * @var \FilesystemStorage\Application\FilesystemStorage\UserAvatarFilesystemStorageInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private MockObject $avatarFilesystemStorageMock;

    public function test(): void
    {
        $this->assertFileHasBeenSaved();
        ($this->useCase)($this->userAvatarChangeCommandFixture());
    }

    private function assertFileHasBeenSaved(): void
    {
        $this->avatarFilesystemStorageMock->expects(self::once())->method('save');
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    private function userAvatarChangeCommandFixture(): UserChangeAvatarCommand
    {
        return new UserChangeAvatarCommand(
            UserId::fromString('2db34ec5-cea2-4693-94e6-ad2f657485cc'),
            $this->getFakeAvatar()
        );
    }

    public function getFakeAvatar(): FakeUserAvatarFile
    {
        return new FakeUserAvatarFile();
    }

    protected function setUp(): void
    {
        $this->avatarFilesystemStorageMock = $this->createMock(UserAvatarFilesystemStorageInterface::class);

        $this->useCase = new UserChangeAvatarHandler(
            new UserCardRepository(),
            new ChangeAvatarService($this->avatarFilesystemStorageMock)
        );
    }
}
