<?php

declare(strict_types=1);

namespace ValueObject\Exception;

use ValueObject\Currency;

final class CurrencyMismatchException extends InvalidArgumentException
{
    /**
     * @param \ValueObject\Currency $baseCurrency
     * @param \ValueObject\Currency $comparedCurrency
     * @return self
     */
    public static function between(Currency $baseCurrency, Currency $comparedCurrency): self
    {
        return new self(sprintf('%s mismatch %s', (string)$baseCurrency, (string)$comparedCurrency));
    }
}
