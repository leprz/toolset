<?php

declare(strict_types=1);

namespace ValueObject;

use ValueObject\Exception\InvalidCurrencyException;

/**
 * @psalm-immutable
 */
final class Currency
{
    /**
     * @var string
     *
     * @psalm-allow-private-mutation
     */
    private string $currency;

    /**
     * @param string $currency
     * @throws \ValueObject\Exception\InvalidCurrencyException
     */
    private function __construct(string $currency)
    {
        $this->setCurrency($currency);
    }

    /**
     * @param string $currency
     * @throws \ValueObject\Exception\InvalidCurrencyException
     */
    private function setCurrency(string $currency): void
    {
        $currency = strtoupper($currency);

        self::assertLength($currency);
        self::assertFormat($currency);

        $this->currency = $currency;
    }

    /**
     *
     * @param string $currency
     * @throws \ValueObject\Exception\InvalidCurrencyException
     *
     * @psalm-pure
     */
    private static function assertLength(string $currency): void
    {
        if (strlen($currency) !== 3) {
            throw InvalidCurrencyException::invalidCodeLength($currency);
        }
    }

    /**
     * @param string $currency
     * @throws \ValueObject\Exception\InvalidCurrencyException
     *
     * @psalm-pure
     */
    private static function assertFormat(string $currency): void
    {
        if (!preg_match('/[A-Z]{3}/i', $currency)) {
            throw InvalidCurrencyException::invalidFormat($currency);
        }
    }

    /**
     * https://www.iso.org/iso-4217-currency-codes.html
     *
     * @param string $currency
     * @return self
     * @throws \ValueObject\Exception\InvalidCurrencyException
     */
    public static function fromISO(string $currency): self
    {
        return new self($currency);
    }

    /**
     * @return self
     */
    public static function PLN(): self
    {
        return new self('PLN');
    }

    /**
     * @return self
     */
    public static function USD(): self
    {
        return new self('USD');
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->currency;
    }

    /**
     * @param \ValueObject\Currency $currency
     * @return bool
     */
    public function equals(Currency $currency): bool
    {
        return $this->currency === $currency->currency;
    }
}
