<?php

declare(strict_types=1);

namespace Persistence\Application\Exception;

use Exception;

class ResultNotFoundException extends Exception
{
    public static function forId(string $id): self
    {
        return new self(sprintf('Result with %s has been not found', $id));
    }
}
