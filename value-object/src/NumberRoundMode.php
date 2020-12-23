<?php

declare(strict_types=1);

namespace ValueObject;

/**
 * @psalm-immutable
 */
final class NumberRoundMode
{
    private int $roundMode;

    /**
     * @param int $roundMode
     */
    private function __construct(int $roundMode)
    {
        $this->roundMode = $roundMode;
    }

    /**
     * @return self
     *
     * @psalm-pure
     */
    public static function roundHalfUp(): self
    {
        return new self(PHP_ROUND_HALF_UP);
    }

    /**
     * @return self
     *
     * @psalm-pure
     */
    public static function roundHalfDown(): self
    {
        return new self(PHP_ROUND_HALF_DOWN);
    }

    /**
     * @return self
     *
     * @psalm-pure
     */
    public static function roundHalfOdd(): self
    {
        return new self(PHP_ROUND_HALF_ODD);
    }

    /**
     * @return self
     *
     * @psalm-pure
     */
    public static function roundHalfEven(): self
    {
        return new self(PHP_ROUND_HALF_EVEN);
    }

    public function asPhpRoundModeValue(): int
    {
        return $this->roundMode;
    }
}
