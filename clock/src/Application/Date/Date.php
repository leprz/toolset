<?php
declare(strict_types=1);

namespace Clock\Application\Date;

use Clock\Application\Date\Builder\AdapterNotInitializedException;
use Clock\Application\Date\Builder\DateBuilderInterface;

class Date
{
    /**
     * @var \Clock\Application\Date\Builder\DateBuilderInterface|null
     */
    private static ?DateBuilderInterface $adapter = null;

    /**
     * @param string $date
     * @return \Clock\Domain\ValueObject\Date
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpDocMissingThrowsInspection
     */
    public static function fromString(string $date): \Clock\Domain\ValueObject\Date
    {
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
     * @param \Clock\Application\Date\Builder\DateBuilderInterface $adapter
     */
    protected static function setAdapter(DateBuilderInterface $adapter): void
    {
        self::$adapter = $adapter;
    }
}
