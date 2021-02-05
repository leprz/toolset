<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests\Infrastructure\FilesystemStorage\LocalPath;

use FilesystemStorage\Application\Exception\InvalidArgumentException;
use FilesystemStorage\Infrastructure\FilesystemStorage\LocalPath;
use PHPUnit\Framework\TestCase;

abstract class LocalPathTest extends TestCase
{
    abstract public function testAppend(): void;

    abstract public function testCreate(): void;

    abstract public function fixablePathDataSet(): array;

    abstract public function invalidPathDataSet(): array;

    /**
     * @dataProvider fixablePathDataSet
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    abstract public function testPathFixup(string $path): void;

    /**
     * @dataProvider invalidPathDataSet
     * @param string $path
     * @throws \FilesystemStorage\Application\Exception\InvalidArgumentException
     */
    abstract public function testPathValidity(string $path): void;

    protected function assertPathEquals(string $expected, LocalPath $path): void
    {
        self::assertEquals($expected, (string)$path);
    }

    protected function assertPathIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
    }
}
