<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests\Application\FilesystemStorage;

use FilesystemStorage\Application\Config\TenantConfig;
use FilesystemStorage\Application\FilesystemStorage\TenantConfig\TenantConfigFilesystemStorageInterface;
use FilesystemStorage\Infrastructure\FilesystemStorage\TenantConfig\TenantConfigJsonMapper;
use FilesystemStorage\Infrastructure\FilesystemStorage\TenantConfig\TenantConfigLocalFilesystemStorage;
use FilesystemStorage\Tests\KernelTestCase;

class TenantConfigFilesystemStorageTest extends KernelTestCase
{
    private TenantConfigFilesystemStorageInterface $storage;

    /** @noinspection PhpUnhandledExceptionInspection */
    public function testSave(): void
    {
        $this->storage->save(new TenantConfig('testName', 2000));
        $this->assertTenantConfigExists();
    }

    private function assertTenantConfigExists(): void
    {
        self::assertTrue($this->storage->exists());
    }

    /**
     * @depends testSave
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function testLoad(): void
    {
        self::assertNotEmpty(($this->storage->load())->getName());
    }

    /**
     * @depends testSave
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function testRemove(): void
    {
        $this->storage->remove();
        $this->assertTenantConfigHasBeenRemoved();
    }

    private function assertTenantConfigHasBeenRemoved(): void
    {
        self::assertFalse($this->storage->exists());
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    protected function setUp(): void
    {
        self::bootKernel();

        $this->storage = new TenantConfigLocalFilesystemStorage(
            self::$kernel->getResourcesDir(),
            new TenantConfigJsonMapper()
        );
    }
}
