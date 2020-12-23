<?php

declare(strict_types=1);

namespace ValueObject;

use OverflowException;
use ValueObject\Exception\CurrencyMismatchException;

/**
 * @psalm-immutable
 */
final class Money
{
    /**
     * Money amount as smallest currency unit e.g cent for USD
     *
     * @var int
     *
     * @psalm-allow-private-mutation
     */
    private int $amount;

    /**
     * @var \ValueObject\Currency
     *
     * @psalm-allow-private-mutation
     */
    private Currency $currency;

    /**
     * @param int $amount
     * @param \ValueObject\Currency $currency
     */
    private function __construct(int $amount, Currency $currency)
    {
        $this->setAmount($amount);
        $this->setCurrency($currency);
    }

    /**
     * @param int $amount
     */
    private function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param \ValueObject\Currency $currency
     */
    private function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @param float $amount
     * @param \ValueObject\Currency $currency
     * @param \ValueObject\NumberRoundMode|null $amountRoundMode
     * @return self
     */
    public static function fromMainUnit(
        float $amount,
        Currency $currency,
        ?NumberRoundMode $amountRoundMode = null
    ): self {
        if ($amountRoundMode === null) {
            $amountRoundMode = self::getDefaultRoundMode();
        }

        if ($amount > PHP_INT_MAX) {
            throw new OverflowException('Max int size exceeded');
        }

        return new self(
            (int)round($amount * 100, 2, $amountRoundMode->asPhpRoundModeValue()),
            $currency
        );
    }

    /**
     * @return \ValueObject\NumberRoundMode
     *
     * @psalm-pure
     */
    private static function getDefaultRoundMode(): NumberRoundMode
    {
        return NumberRoundMode::roundHalfUp();
    }

    /**
     * @param int $amount
     * @param \ValueObject\Currency $currency
     * @return self
     */
    public static function fromSubUnit(int $amount, Currency $currency): self
    {
        return new self($amount, $currency);
    }

    /**
     * @param \ValueObject\Money $money
     * @return self
     * @throws \ValueObject\Exception\CurrencyMismatchException
     */
    public function add(self $money): self
    {
        self::assertSameCurrency($this, $money);

        return new self($this->amount + $money->amount, $this->currency);
    }

    /**
     * @param \ValueObject\Money $money
     * @return $this
     * @throws \ValueObject\Exception\CurrencyMismatchException
     */
    public function subtract(self $money): self
    {
        self::assertSameCurrency($this, $money);

        return new self($this->amount - $money->amount, $this->currency);
    }

    /**
     * @param \ValueObject\Money $money1
     * @param \ValueObject\Money $money2
     * @throws \ValueObject\Exception\CurrencyMismatchException
     *
     * @psalm-pure
     */
    private static function assertSameCurrency(Money $money1, Money $money2): void
    {
        if (!$money1->currency->equals($money2->currency)) {
            throw CurrencyMismatchException::between($money1->currency, $money2->currency);
        }
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getAmountInMainUnit(): float
    {
        return (float)$this->amount / 100;
    }

    /**
     * @param float $factor
     * @param \ValueObject\NumberRoundMode|null $moneyRoundMode
     * @return self
     */
    public function multiply(float $factor, ?NumberRoundMode $moneyRoundMode = null): self
    {
        if ($moneyRoundMode === null) {
            $moneyRoundMode = self::getDefaultRoundMode();
        }

        return new self(
            (int)round($this->amount * $factor, 0, $moneyRoundMode->asPhpRoundModeValue()),
            $this->currency
        );
    }
}
