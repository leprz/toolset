<?php
declare(strict_types=1);

namespace SharedKernel\Domain\ValueObject;

use SharedKernel\Domain\Exception\InvalidArgumentException;

trait UuidV4Trait
{
    /**
     * @var string
     */
    private string $uuid;

    /**
     * @param string $uuid
     * @throws \SharedKernel\Domain\Exception\InvalidArgumentException
     */
    final private function __construct(string $uuid)
    {
        $uuid = self::normalizeUuid($uuid);

        self::assertUuidFormat($uuid);

        $this->uuid = $uuid;
    }

    /**
     * @param string $uuid
     * @throws \SharedKernel\Domain\Exception\InvalidArgumentException
     */
    protected static function assertUuidFormat(string $uuid): void
    {
        if (!self::isUuidValid($uuid)) {
            throw new InvalidArgumentException(sprintf("Uuid [%s] is invalid", $uuid));
        }
    }

    /**
     * @param string $uuid
     * @return string
     */
    private static function normalizeUuid(string $uuid): string
    {
        return strtoupper($uuid);
    }

    /**
     * @param string $uuid
     * @return bool
     */
    private static function isUuidValid(string $uuid): bool
    {
        return 1 === preg_match(
            "/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}\$/",
            $uuid
        );
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->uuid;
    }
}
