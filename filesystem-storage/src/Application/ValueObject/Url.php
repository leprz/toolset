<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\ValueObject;

use FilesystemStorage\Application\Config\Exception\InvalidConfigException;

class Url
{
    private string $url;
/**
     * @param string $url
     * @throws \FilesystemStorage\Application\Config\Exception\InvalidConfigException
     */
    public function __construct(string $url)
    {
        $this->setUrl($url);
    }

    /**
     * @param string $url
     * @throws \FilesystemStorage\Application\Config\Exception\InvalidConfigException
     */
    private function setUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidConfigException(sprintf('Provided url [%s] is invalid', $url));
        }

        $this->url = $url;
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
