<?php

declare(strict_types=1);

namespace Persistence\Infrastructure\Persistence\Customer;

use Persistence\Domain\ValueObject\CustomerId;

class CustomerIdGenerator
{
    /**
     * @return string
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpDocMissingThrowsInspection
     */
    private static function generateUuidV4(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000,
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff)
        );
    }

    /**
     * @return \Persistence\Domain\ValueObject\CustomerId
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpDocMissingThrowsInspection
     */
    public function generate(): CustomerId
    {
        return CustomerId::fromString(self::generateUuidV4());
    }
}
