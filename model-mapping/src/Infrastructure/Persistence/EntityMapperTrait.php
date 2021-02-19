<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use ReflectionMethod;

trait EntityMapperTrait
{
    private function createNewInstanceWithoutConstructor(string $class): mixed
    {
        try {
            return (new \ReflectionClass($class))->newInstanceWithoutConstructor();
        } catch (\ReflectionException $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    private function mapProperties($model, $entity, ?EntityManagerInterface $entityManager = null): mixed
    {
        $reflectionClass = new \ReflectionClass($model);
        $props = $reflectionClass->getProperties();

        foreach ($props as $prop) {
            $propName = $prop->getName();

            if ($propName === 'entity') {
                continue;
            }

            $prop->setAccessible(true);
            $setter = $this->propNameToSetter($propName);

            if ($entityManager && $this->doesRequireEntityManger($entity, $setter)) {
                $entity->{$setter}($prop->getValue($model), $entityManager);
            } else {
                $entity->{$setter}($prop->getValue($model));
            }
        }

        return $entity;
    }

    private function doesRequireEntityManger($entity, string $methodName): bool
    {
        $reflectionMethod = new ReflectionMethod($entity, $methodName);
        $params = $reflectionMethod->getParameters();
        return count($params) > 1;
    }

    private function propNameToSetter(string $propName): string
    {
        return 'set' . ucfirst($propName);
    }
}
