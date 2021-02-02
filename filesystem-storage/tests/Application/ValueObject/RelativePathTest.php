<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests\Application\ValueObject;

use FilesystemStorage\Application\Exception\InvalidArgumentException;
use FilesystemStorage\Application\ValueObject\RelativePath;
use PHPUnit\Framework\TestCase;

class RelativePathTest extends TestCase
{
    /** @noinspection PhpUnhandledExceptionInspection */
    public function testAppendFile(): void
    {
        $this->assertPathEquals(
            '/test/path/test.txt',
            (RelativePath::fromString('/test/path'))->append('test.txt')
        );
    }

    private function assertPathEquals(string $expected, RelativePath $path): void
    {
        self::assertEquals($expected, (string)$path);
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testAppendDir(): void
    {
        $this->assertPathEquals(
            '/test/path/test',
            (RelativePath::fromString('/test/path'))->append('test')
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testPrependDir(): void
    {
        $this->assertPathEquals(
            '/dir/test/path',
            (RelativePath::fromString('/test/path'))->prependDir('dir')
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testPrependMultipleDirs(): void
    {
        $this->assertPathEquals(
            '/foo/bar/test/path',
            (RelativePath::fromString('/test/path'))->prependDir('/foo/bar')
        );
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testMultipleSlashes(): void
    {
        $this->assertPathEquals('/test/path', (RelativePath::fromString('/test//path')));
        $this->assertPathEquals('/test/path', (RelativePath::fromString('/test///path')));
        $this->assertPathEquals('/test/path', (RelativePath::fromString('/test/////path')));
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testRemovingTrailingSlash(): void
    {
        $this->assertPathEquals('/test/filename.txt', RelativePath::fromString('/test/filename.txt/'));
        $this->assertPathEquals('/test/dir', RelativePath::fromString('/test/dir/'));
    }

    public function badFilenames(): array
    {
        return [
            ['/test/filename.txt/test.txt'],
            ['/test/filename.'],
            ['/filename.txt/test'],
        ];
    }

    /**
     * @dataProvider badFilenames
     *
     * @param string $filename
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    public function testInvalidFilename(string $filename): void
    {
        $this->assertPathIsInvalid();

        RelativePath::fromString($filename);
    }

    private function assertPathIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testHasLeadingSlash(): void
    {
        $this->assertPathIsInvalid();

        RelativePath::fromString('test/path');
    }
}
