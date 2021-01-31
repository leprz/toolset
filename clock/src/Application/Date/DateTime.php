<?php
declare(strict_types=1);

namespace Clock\Application\Date;

use Clock\Application\Date\Builder\AdapterNotInitializedException;
use Clock\Application\Date\Builder\DateTimeBuilderInterface;

class DateTime
{
    /**
     * @var \Clock\Application\Date\Builder\DateTimeBuilderInterface|null
     */
    private static ?DateTimeBuilderInterface $adapter = null;

    /**
     * @param string $date
     * @return \Clock\Domain\ValueObject\DateTime
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpDocMissingThrowsInspection
     */
    public static function fromString(string $date): \Clock\Domain\ValueObject\DateTime
    {
        // TODO if now throw exception with message to use system clock instead

        if (!self::$adapter) {
            self::throwAdapterNotInitializedException();
        }

        return self::$adapter::fromString($date);
    }

    /**
     * @throws \Clock\Application\Date\Builder\AdapterNotInitializedException
     */
    private static function throwAdapterNotInitializedException(): void
    {
        throw AdapterNotInitializedException::fromClassName(self::class);
    }

    /**
     * @param \Clock\Application\Date\Builder\DateTimeBuilderInterface $adapter
     */
    protected static function setAdapter(DateTimeBuilderInterface $adapter): void
    {
        self::$adapter = $adapter;
    }
}
