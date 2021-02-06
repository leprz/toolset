<?php
declare(strict_types=1);

namespace Clock\Application\Date;

use Clock\Application\Date\Builder\AdapterNotInitializedException;
use Clock\Application\Date\Builder\DateTimeBuilderInterface;
use Clock\Application\Exception\InvalidArgumentException;

class DateTime
{
    /**
     * @var \Clock\Application\Date\Builder\DateTimeBuilderInterface|null
     */
    private static ?DateTimeBuilderInterface $adapter = null;

    /**
     * @param string $date
     * @return \Clock\Domain\ValueObject\DateTime
     * @throws \Clock\Application\Exception\InvalidArgumentException
     */
    public static function fromString(string $date): \Clock\Domain\ValueObject\DateTime
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
     * @return \Clock\Application\Date\Builder\DateTimeBuilderInterface
     */
    private static function adapter(): DateTimeBuilderInterface
    {
        if (self::$adapter === null) {
            throw AdapterNotInitializedException::fromClassName(self::class);
        }

        return self::$adapter;
    }

    /**
     * @param \Clock\Application\Date\Builder\DateTimeBuilderInterface $adapter
     */
    protected static function setAdapter(DateTimeBuilderInterface $adapter): void
    {
        self::$adapter = $adapter;
    }
}
