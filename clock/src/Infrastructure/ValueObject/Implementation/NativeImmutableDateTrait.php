<?php
declare(strict_types=1);

namespace Clock\Infrastructure\ValueObject\Implementation;

use DateInterval;
use DateTimeImmutable;

trait NativeImmutableDateTrait
{
    /**
     * @var \DateTimeImmutable
     */
    protected DateTimeImmutable $date;

    /**
     * @param \DateTimeImmutable $date
     */
    public function __construct(DateTimeImmutable $date)
    {
        $this->date = $date->setTime(0, 0, 0);
    }

    /**
     * @param int $days
     * @return static
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpDocMissingThrowsInspection
     */
    private function addDays(int $days): self
    {
        return new static(
            $this->date->add(
                new DateInterval(
                    sprintf('P%sD', $days)
                )
            )
        );
    }

    /**
     * @param mixed $date
     * @return bool
     */
    private function lessThanOrEqual($date): bool
    {
        return $this->date <= $date->getDate();
    }

    /**
     * @return \DateTimeImmutable
     */
    protected function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->date->format('Y-m-d');
    }
}
