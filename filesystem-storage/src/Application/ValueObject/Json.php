<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\ValueObject;

use InvalidArgumentException;
use JsonException;

class Json
{
    /**
     * @var string
     */
    private string $json;

    /**
     * @param string $json
     */
    private function __construct(string $json)
    {
        $this->json = $json;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): self
    {
        try {
            return new self(json_encode($data, JSON_THROW_ON_ERROR + JSON_PRETTY_PRINT));
        } catch (JsonException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param string $json
     * @return static
     */
    public static function fromString(string $json): self
    {
        try {
            self::jsonToArray($json);
        } catch (JsonException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return new self($json);
    }

    /**
     * @param string $json
     * @return array
     * @throws \JsonException
     */
    private static function jsonToArray(string $json): array
    {
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @return array
     * @noinspection PhpDocMissingThrowsInspection
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function toArray(): array
    {
        return self::jsonToArray($this->json);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->json;
    }
}
