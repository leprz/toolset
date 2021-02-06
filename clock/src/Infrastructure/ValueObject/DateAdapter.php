<?php
declare(strict_types=1);

namespace Clock\Infrastructure\ValueObject;

use Carbon\CarbonImmutable;
use Clock\Application\Date\Builder\DateBuilderInterface;
use Clock\Domain\Exception\InvalidArgumentException;
use Clock\Domain\ValueObject\Date as DomainDate;
use Clock\Infrastructure\ValueObject\Implementation\CarbonDateTrait;
use Exception;

class DateAdapter extends DomainDate implements DateBuilderInterface
{
    use CarbonDateTrait {
        CarbonDateTrait::addDays as _addDays;
        CarbonDateTrait::lessThanOrEqual as _lessThanOrEqual;
    }

    /**
     * @param string $date
     * @return \Clock\Infrastructure\ValueObject\DateAdapter
     * @throws \Clock\Domain\Exception\InvalidArgumentException
     */
    public static function fromString(string $date): self
    {
        try {
            return new self(new CarbonImmutable($date));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function addDays(int $days): self
    {
        return $this->_addDays($days);
    }

    /**
     * @param \Clock\Domain\ValueObject\Date $date
     * @return bool
     */
    public function lessThanOrEqual(DomainDate $date): bool
    {
        return $this->_lessThanOrEqual($date);
    }
}
