<?php
declare(strict_types=1);

namespace SharedKernel\Domain\ValueObject;

use SharedKernel\Domain\Exception\InvalidArgumentException;

trait EmailTrait
{
    /**
     * @var string
     */
    private string $email;

    /**
     * @param string $email
     * @throws \SharedKernel\Domain\Exception\InvalidArgumentException
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private function __construct(string $email)
    {
        $email = self::normalizeEmail($email);

        static::assertEmailFormat($email);

        $this->email = $email;
    }

    /**
     * @param string $email
     * @throws \SharedKernel\Domain\Exception\InvalidArgumentException
     */
    private static function assertEmailFormat(string $email): void
    {
        if (!self::isEmailValid($email)) {
            throw new InvalidArgumentException(self::invalidArgumentExceptionMessage($email));
        }
    }

    private static function isEmailValid(string $email): bool
    {
        return false !== filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private static function normalizeEmail(string $email): string
    {
        return strtolower($email);
    }

    private static function invalidArgumentExceptionMessage(string $email): string
    {
        return sprintf('Email [%s] is invalid', $email);
    }

    /**
     * @param static $email
     * @return bool
     */
    public function equals(self $email): bool
    {
        return $this->email === $email->email;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->email;
    }
}
