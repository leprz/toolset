<?php

declare(strict_types=1);

namespace Persistence\Infrastructure\DataSource;

use Persistence\Application\Exception\ResultNotFoundException;

class CustomerDataSource
{
    /**
     * @var array<mixed>
     */
    private static array $customers = [
        ['8B8B3F05-96BE-473C-80BF-5D6F2D0B1449', 'john.doe@example.com', 'John', 'Doe']
    ];

    /**
     * @param array<mixed> $row
     */
    public function add(array $row): void
    {
        self::$customers[] = $row;
    }

    /**
     * @return array<array<mixed>>
     */
    public function getAll(): array
    {
        return self::$customers;
    }

    /**
     * @param string $id
     * @return array<mixed>
     * @throws \Persistence\Application\Exception\ResultNotFoundException
     */
    public function getById(string $id): array
    {
        return self::$customers[$this->searchCustomerKeyById($id)];
    }

    /**
     * @param string $id
     * @return int
     * @throws \Persistence\Application\Exception\ResultNotFoundException
     */
    private function searchCustomerKeyById(string $id): int
    {
        $i = array_search($id, array_column(self::$customers, 0), true);

        if ($i === false) {
            throw ResultNotFoundException::forId($id);
        }

        return (int)$i;
    }

    /**
     * @param string $id
     * @throws \Persistence\Application\Exception\ResultNotFoundException
     */
    public function remove(string $id): void
    {
        array_splice(self::$customers, $this->searchCustomerKeyById($id), 1);
    }

    /**
     * @param string $id
     * @param array<mixed> $row
     * @throws \Persistence\Application\Exception\ResultNotFoundException
     */
    public function update(string $id, array $row): void
    {
        self::$customers[$this->searchCustomerKeyById($id)] = $row;
    }
}
