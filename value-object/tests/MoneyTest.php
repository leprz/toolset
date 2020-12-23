<?php

declare(strict_types=1);

namespace ValueObject\Tests;

use OverflowException;
use PHPUnit\Framework\TestCase;
use ValueObject\Currency;
use ValueObject\Exception\CurrencyMismatchException;
use ValueObject\Money;

class MoneyTest extends TestCase
{
    public function testCreateFromMainUnit(): void
    {
        $oneNinetyNine = Money::fromMainUnit(1.99, Currency::USD());

        // assert $1.99 equals 199 cents
        self::assertEquals(199, $oneNinetyNine->getAmount());

        $oneNinetyNineWithHighPrecision = Money::fromMainUnit(1.9999999999999999999999999, Currency::USD());

        // assert $1.9999999999999999999999999 is rounded up by default and equals 200 cents
        self::assertEquals(200, $oneNinetyNineWithHighPrecision->getAmount());
    }

    public function testAdd(): void
    {
        $oneDollar = Money::fromMainUnit(1.00, Currency::USD());

        $twoDollars = $oneDollar->add($oneDollar);

        // assert $1.00 + $1.00 = $2.00
        self::assertequals(2.00, $twoDollars->getAmountInMainUnit());
    }

    public function testSubtract(): void
    {
        $oneDollar = Money::fromMainUnit(1.00, Currency::USD());
        $tenCents = Money::fromSubUnit(10, Currency::USD());

        $ninetyCents = $oneDollar->subtract($tenCents);

        // assert $1.00 - 10 cents = 90 cents
        self::assertEquals(90, $ninetyCents->getAmount());
    }

    public function testMultiply(): void
    {
        $oneDollar = Money::fromMainUnit(1.00, Currency::USD());
        $halfDollar = $oneDollar->multiply(0.5);

        // assert $1.00 * 0.5 = 50 cents
        self::assertEquals(50, $halfDollar->getAmount());

        $oneNinetyNine = Money::fromMainUnit(1.99, Currency::USD());
        $threeNinetyEight = $oneNinetyNine->multiply(2);

        // assert $1.99 * 2 = $3.98
        self::assertEquals(3.98, $threeNinetyEight->getAmountInMainUnit());
    }

    public function testAddingMoneyWithMismatchingCurrencies(): void
    {
        $oneDollar = Money::fromMainUnit(1.00, Currency::USD());
        $oneZloty = Money::fromMainUnit(1.00, Currency::PLN());

        $this->assertThatMismatchingCurrencyIsValidated();

        $oneDollar->add($oneZloty);
    }

    public function testVeryBigAmount(): void
    {
        // assert float casted to int do not overflow PHP_MAX_INT size
        $this->expectException(OverflowException::class);

        Money::fromMainUnit(9e19, Currency::USD());
    }

    private function assertThatMismatchingCurrencyIsValidated(): void
    {
        $this->expectException(CurrencyMismatchException::class);
    }
}
