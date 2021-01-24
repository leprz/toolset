<?php

declare(strict_types=1);

namespace FilesystemStorage\Infrastructure\FilesystemStorage;

class PathUtils
{
    public static function unifyDirectorySeparators(string $path): string
    {
        return str_replace(array('/', '\\'), array(DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR), $path);
    }

    public static function unifyTrailingSlashes(string $path): string
    {
        $path = ltrim($path, '\\');
        $path = ltrim($path, '/');
        $path = rtrim($path, '\\');
        $path = rtrim($path, '/');
        return DIRECTORY_SEPARATOR . $path;
    }
}
