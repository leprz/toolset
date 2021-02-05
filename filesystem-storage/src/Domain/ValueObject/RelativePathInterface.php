<?php

declare(strict_types=1);

namespace FilesystemStorage\Domain\ValueObject;

interface RelativePathInterface
{
    /**
     * @return string
     */
    public function __toString(): string;
}
