<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixture;

use Faker\Factory;
use Faker\Generator;

class Faker
{
    private Generator $generator;

    public function __construct()
    {
        $this->generator = Factory::create();
        $this->generator->seed(ReferenceFixture::$SEED);
    }

    public function build(): Generator
    {
        return $this->generator;
    }
}
