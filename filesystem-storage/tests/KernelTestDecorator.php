<?php

declare(strict_types=1);

namespace FilesystemStorage\Tests;

use FilesystemStorage\Kernel;

class KernelTestDecorator extends Kernel
{
    public function __construct(Kernel $kernel)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        parent::__construct((string) $kernel->resourcesPath->append('tests'));
    }
}
