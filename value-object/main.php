<?php

declare(strict_types=1);

use ValueObject\Currency;
use ValueObject\Money;

/**
 * @noinspection PhpUnhandledExceptionInspection
 */
function main(): void
{
    $twoDollars = Money::fromMainUnit(2.0, Currency::fromISO('USD'));

    printf("$2 = %s cents \n", $twoDollars->getAmount());

    $threeDollars = $twoDollars->add(Money::fromMainUnit(1.0, Currency::fromISO('USD')));

    printf("$%s = %s cents \n", $threeDollars->getAmountInMainUnit(), $threeDollars->getAmount());
}
