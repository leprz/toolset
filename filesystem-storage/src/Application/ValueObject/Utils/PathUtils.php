<?php

declare(strict_types=1);

namespace FilesystemStorage\Application\ValueObject\Utils;

class PathUtils
{
    /**
     * @var string
     */
    protected static string $directorySeparator = DIRECTORY_SEPARATOR;

    public static function fixIncorrectDirectorySeparators(string $path): string
    {
        return str_replace(array('/', '\\'), array(self::$directorySeparator, self::$directorySeparator), $path);
    }

    public static function fixBoundaryDirectorySeparators(string $path): string
    {
        $path = trim($path, '\\');
        $path = trim($path, '/');

        return self::$directorySeparator . $path;
    }

    public static function removeTrailingSlashes(string $path): string
    {
        return rtrim($path, '\\/');
    }

    public static function getFilename(string $path): ?string
    {
        if (self::hasFilename($path)) {
            $pathChunks = explode(self::$directorySeparator, $path);
            $potentialFilename = end($pathChunks);
            if (self::isFilename($potentialFilename)) {
                return $potentialFilename;
            }
        }

        return null;
    }

    public static function hasFilename(string $filename): bool
    {
        return substr_count($filename, '.') > 0;
    }

    public static function isFilename(string $filename): bool
    {
        return substr_count($filename, '.') === 1;
    }

    public static function hasOnlyOneFilename(string $path): bool
    {
        return substr_count($path, '.') <= 1;
    }

    public static function removeDuplicatedDirectorySeparators(string $path): string
    {
        if (self::isUnix()) {
            return self::removeDuplicatedForwardSlashes($path);
        }

        return self::removeDuplicatedBackSlashes($path);
    }

    private static function isUnix(): bool
    {
        return self::$directorySeparator === '/';
    }

    public static function removeDuplicatedForwardSlashes(string $path): string
    {
        return preg_replace('/(\/+)/', '/', $path);
    }

    private static function removeDuplicatedBackSlashes(string $path): string
    {
        return preg_replace('/\\\\{2,}/', "\\", $path);
    }

    public static function hasValidFormat(string $path): bool
    {
        if (self::isPathEmpty($path)) {
            return false;
        }

        if (self::isWindows()) {
            return self::isValidWindowsPath($path);
        }

        if (self::isUnix()) {
            return self::isValidUnixPath($path);
        }

        return false;
    }

    private static function isPathEmpty(string $path): bool
    {
        return $path === '';
    }

    private static function isWindows(): bool
    {
        return self::$directorySeparator === '\\';
    }

    private static function isValidWindowsPath(string $path): bool
    {
        return 1 === preg_match('/^[a-zA-Z]:[\\\\].+/', $path);
    }

    private static function isValidUnixPath(string $path): bool
    {
        return 1 === preg_match('/^(\/)?([^\/\0]+(\/)?)+$/', $path);
    }

    public static function hasDirectorySwitchesOrWildcards(string $path): bool
    {
        $chars = ['~', '*', '..', './', '/.', '\\.', '.\\'];

        if (self::isUnix()) {
            $chars[] = ':';
        }

        foreach ($chars as $char) {
            if (self::hasChar($char, $path)) {
                return true;
            }
        }

        return false;
    }

    private static function hasChar(string $char, string $path): bool
    {
        return strpos($path, $char) !== false;
    }

    public static function hasTrailingDot(string $path): bool
    {
        if ($path !== '') {
            return strpos($path, '.', strlen($path) - 1) !== false;
        }

        return false;
    }
}
