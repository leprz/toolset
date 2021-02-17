<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Exception;

use RuntimeException;

class CanNotSaveNotExistingEntityException extends RuntimeException
{
    public static function fromEntityName(string $class): self
    {
        return new self(
            sprintf('Can not save not existing entity [%s]', $class)
        );
    }
}
