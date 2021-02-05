<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\Config\Exception;

use Exception;
use Throwable;

class InvalidConfigException extends Exception
{
    /**
     * @var array
     */
    private array $requiredProperties = [];

    /**
     * @var string
     */
    private string $configName;

    /**
     * @param string $configName
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $configName, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->configName = $configName;
    }

    /**
     * @param string $requiredPropertyName
     */
    public function addMissingProperty(string $requiredPropertyName): void
    {
        $this->requiredProperties[] = $requiredPropertyName;

        $this->message = sprintf(
            'Missing required properties [%s] in %s',
            implode(',', $this->requiredProperties),
            $this->configName,
        );
    }
}
