<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests\Application\FilesystemStorage;

use FilesystemStorage\Application\Config\TenantConfig;
use FilesystemStorage\Application\FilesystemStorage\TenantConfigFilesystemStorageInterface;
use FilesystemStorage\Infrastructure\FilesystemStorage\TenantConfig\TenantConfigLocalFilesystemStorage;
use FilesystemStorage\Infrastructure\FilesystemStorage\TenantConfig\TenantConfigJsonMapper;
use FilesystemStorage\Tests\KernelTestCase;

class TenantConfigFilesystemStorageTest extends KernelTestCase
{
    private TenantConfigFilesystemStorageInterface $storage;
    public function testSave(): void
    {
        $this->storage->save(new TenantConfig('testName', 2000));
        $this->assertTenantConfigExists();
    }

    /**
     * @depends testSave
     */
    public function testLoad(): void
    {
        self::assertNotEmpty(($this->storage->load())->getName());
    }

    /**
     * @depends testSave
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

    private function assertTenantConfigExists(): void
    {
        self::assertTrue($this->storage->exists());
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $this->storage = new TenantConfigLocalFilesystemStorage(
            self::$kernel->getResourcesDir(),
            new TenantConfigJsonMapper()
        );
    }
}
