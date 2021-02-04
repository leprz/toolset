<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests\Application\UseCase\UserChangeAvatar;

use FilesystemStorage\Domain\ValueObject\FileInterface;
use FilesystemStorage\Infrastructure\FilesystemStorage\LocalPath;

class FakeUserAvatarFileInterface implements FileInterface
{
    /** @noinspection PhpUnhandledExceptionInspection */
    public function getContents(): string
    {
        return file_get_contents((string) new LocalPath(__DIR__ . '/assets/robot.png'));
    }

    public function getExtension(): string
    {
        return 'png';
    }
}
