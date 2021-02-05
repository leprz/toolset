<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests\Infrastructure\FilesystemStorage\LocalPath;

use FilesystemStorage\Application\ValueObject\Utils\PathUtils;
use FilesystemStorage\Infrastructure\FilesystemStorage\LocalPath;

class LocalPathUnixTest extends LocalPathTest
{
    public function testCreate(): void
    {
        $this->assertPathEquals('/var/www/html', new LocalPath('/var/www/html'));
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testAppend(): void
    {
        $this->assertPathEquals('/var/www/html', (new LocalPath('/var/www'))->append('html'));
    }

    public function fixablePathDataSet(): array
    {
        return [
            ['/var/www'],
            ['/////var///www'],
            ['/var/www/'],
            ['\\var\\\\www'],
            ['/var\\www'],
        ];
    }

    /**
     * @dataProvider fixablePathDataSet
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public function testPathFixup(string $path): void
    {
        $this->assertPathEquals('/var/www', new LocalPath($path));
    }

    public function invalidPathDataSet(): array
    {
        return [
            [''],
            ['C:'],
            ['~/test'],
            ['/var/..'],
            ['./var/www'],
            ['/var/test.txt/www'],
            ['/var/www.'],
            ['/var/www/*'],
        ];
    }

    /**
     * @dataProvider invalidPathDataSet
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public function testPathValidity(string $path): void
    {
        $this->assertPathIsInvalid();
        new LocalPath($path);
    }


    protected function setUp(): void
    {
        (new class () extends PathUtils {
            public function setDirectorySeparator(string $ds): void
            {
                self::$directorySeparator = $ds;
            }
        })->setDirectorySeparator('/');
    }
}
