<?php
declare(strict_types=1);

namespace Clock\Application\Date\Builder;

use Exception;

final class AdapterNotInitializedException extends Exception
{
    /**
     * @param string $className
     * @return self
     */
    public static function fromClassName(string $className): self
    {
        return new self(sprintf('Adapter in [%s] has been not initialized', $className));
    }
}
