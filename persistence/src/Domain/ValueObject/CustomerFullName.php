<?php

declare(strict_types=1);

namespace Persistence\Domain\ValueObject;

class CustomerFullName
{
    /**
     * @var string
     */
    private string $firstName;

    /**
     * @var string
     */
    private string $lastName;

    /**
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(string $firstName, string $lastName)
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    /**
     * @param string $firstName
     */
    private function setFirstName(string $firstName): void
    {
        /** Some assertions rules */
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    private function setLastName(string $lastName): void
    {
        /** Some assertions rules */
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }
}
