<?php
declare(strict_types=1);

namespace Clock\Application\Date;

use Clock\Application\Date\Builder\AdapterNotInitializedException;
use Clock\Application\Date\Builder\DateBuilderInterface;
use Clock\Application\Exception\InvalidArgumentException;

class Date
{
    /**
     * @var \Clock\Application\Date\Builder\DateBuilderInterface|null
     */
    private static ?DateBuilderInterface $adapter = null;

    /**
     * @param string $date
     * @return \Clock\Domain\ValueObject\Date
     * @throws \Clock\Application\Exception\InvalidArgumentException
     */
    public static function fromString(string $date): \Clock\Domain\ValueObject\Date
    {
        self::assertHasNoDynamicDates($date);

        return self::adapter()::fromString($date);
    }

    /**
     * @param string $date
     * @throws \Clock\Application\Exception\InvalidArgumentException
     */
    private static function assertHasNoDynamicDates(string $date): void
    {
        if ($date === 'now') {
            throw new InvalidArgumentException(
                sprintf(
                    'Can not use dynamically created date. Please use %s instead of [%s]',
                    ClockInterface::class,
                    $date
                )
            );
        }
    }

    /**
     * @return \Clock\Application\Date\Builder\DateBuilderInterface
     * @throws \Clock\Application\Date\Builder\AdapterNotInitializedException
     */
    private static function adapter(): DateBuilderInterface
    {
        if (self::$adapter === null) {
            throw AdapterNotInitializedException::fromClassName(self::class);
        }

        return self::$adapter;
    }

    /**
     * @param \Clock\Application\Date\Builder\DateBuilderInterface $adapter
     */
    protected static function setAdapter(DateBuilderInterface $adapter): void
    {
        self::$adapter = $adapter;
    }
}
