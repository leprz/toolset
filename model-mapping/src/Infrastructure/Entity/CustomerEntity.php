<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity;

use App\Domain\ValueObject\CustomerId;
use App\Infrastructure\Entity\Trait\EntityUuidTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @package App\Infrastructure\Entity
 * @ORM\Entity()
 * @ORM\Table(name="customer")
 */
class CustomerEntity
{
    use EntityUuidTrait;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $fullName;

    public function __construct(CustomerId $id, string $fullName)
    {
        $this->setId($id);
        $this->setFullName($fullName);
    }

    public function setId(CustomerId $id): void
    {
        $this->id = (string)$id;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getId(): CustomerId
    {
        return CustomerId::fromString($this->id);
    }
}
