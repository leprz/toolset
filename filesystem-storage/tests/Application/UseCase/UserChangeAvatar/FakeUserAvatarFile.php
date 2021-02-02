<?php
declare(strict_types=1);

namespace FilesystemStorage\Tests\Application\UseCase\UserChangeAvatar;

use FilesystemStorage\Domain\ValueObject\File;
use FilesystemStorage\Infrastructure\FilesystemStorage\LocalPath;

class FakeUserAvatarFile implements File
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
