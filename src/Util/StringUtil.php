<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Util;

/**
 * @internal
 *
 * @author Simon André <smn.andre@gmail.com>
 */
final class StringUtil
{
    /**
     * @var array<string, string>
     */
    private static array $camelCaseToKebabCaseCache = [];

    /**
     * Convert a camelCase string to kebab-case.
     */
    public static function camelCaseToKebabCase(string $string): string
    {
        if (isset(self::$camelCaseToKebabCaseCache[$string])) {
            return self::$camelCaseToKebabCaseCache[$string];
        }

        $result = preg_replace('/(?<!^)[A-Z]/u', '-$0', $string);
        if (!is_string($result)) {
            throw new \RuntimeException('Failed to convert camelCase string to kebab-case.');
        }

        return self::$camelCaseToKebabCaseCache[$string] = strtolower($result);
    }
}
