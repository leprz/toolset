<?php

declare(strict_types=1);

namespace FilesystemStorage\Domain\ValueObject;

interface FileInterface
{
    /**
     * @return string
     */
    public function getContents(): string;

    /**
     * @return string
     */
    public function getExtension(): string;
}
