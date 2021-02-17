<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait EntityUuidTrait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=36, unique=true)
     * @var string
     */
    public string $id;
}
