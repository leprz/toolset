<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace ValueObject\Tests;

use PHPUnit\Framework\TestCase;
use ValueObject\Currency;
use ValueObject\Exception\InvalidCurrencyException;

class CurrencyTest extends TestCase
{
    public function testCurrencyLengthValidation(): void
    {
        $this->expectValidationError();

        /** To long currency code */
        Currency::fromISO('DDDD');
    }

    public function testCurrencyFormatValidation(): void
    {
        $this->expectValidationError();

        /** Currency code should not have any numbers */
        Currency::fromISO('US1');
    }

    public function testCurrencyCapitalization(): void
    {
        /** Currency code should be unified to uppercase */
        self::assertEquals('USD', (string) Currency::fromISO('usd'));
    }

    public function testCurrencyEquals(): void
    {
        self::assertTrue(
            (Currency::PLN())->equals(Currency::PLN())
        );

        self::assertFalse(
            (Currency::PLN())->equals(Currency::USD())
        );
    }

    private function expectValidationError(): void
    {
        $this->expectException(InvalidCurrencyException::class);
    }
}
