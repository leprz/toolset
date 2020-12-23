<?php

declare(strict_types=1);

namespace ValueObject\Exception;

final class InvalidCurrencyException extends InvalidArgumentException
{
    /**
     * @param $currency
     * @return self
     */
    public static function invalidCodeLength(string $currency): self
    {
        $currencyLength = strlen($currency);

        return new self(
            sprintf("Currency code length should equals 3 not %s. %s", $currencyLength, self::getErrorHintMessage())
        );
    }

    /**
     * @param string $currency
     * @return self
     */
    public static function invalidFormat(string $currency): self
    {
        return new self($currency . ' :' . self::getErrorHintMessage());
    }

    /**
     * @return string
     */
    private static function getErrorHintMessage(): string
    {
        return "Currency must follow ISO 4217 format. Example valid currency is USD";
    }
}
