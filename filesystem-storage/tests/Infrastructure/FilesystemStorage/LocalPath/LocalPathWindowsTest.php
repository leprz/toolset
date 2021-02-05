<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests\Infrastructure\FilesystemStorage\LocalPath;

use FilesystemStorage\Application\ValueObject\Utils\PathUtils;
use FilesystemStorage\Infrastructure\FilesystemStorage\LocalPath;

class LocalPathWindowsTest extends LocalPathTest
{
    public function testCreate(): void
    {
        $this->assertPathEquals('C:\\test\\test', new LocalPath('C:\\test\\test'));
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testAppend(): void
    {
        $this->assertPathEquals('C:\\test\\test', (new LocalPath('C:\\test'))->append('test'));
    }

    public function invalidPathDataSet(): array
    {
        return [
            [''],
            ['C:'],
            [':\\'],
            ['\\test'],
            ['/test'],
            ['C:\\test\\..\\test'],
            ['C:\\test\\.\\test'],
            ['C:\\test\\test.txt\\test'],
            ['C:\\test\\test.'],
            ['C:\\test\\*'],
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

    public function fixablePathDataSet(): array
    {
        return [
            ['C:\\\\\\test\\\\test'],
            ['C:\\test\\test\\'],
            ['C://test///test'],
            ['C://test\\/test'],
        ];
    }

    /**
     * @dataProvider fixablePathDataSet
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public function testPathFixup(string $path): void
    {
        $this->assertPathEquals('C:\\test\\test', new LocalPath($path));
    }

    protected function setUp(): void
    {
        $pathUtilsFixture = new class () extends PathUtils {
            public function setDirectorySeparator(string $ds): void
            {
                self::$directorySeparator = $ds;
            }
        };
        $pathUtilsFixture->setDirectorySeparator("\\");
    }
}
