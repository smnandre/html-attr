<?php

namespace Symfony\UX\Html\Escaper;

/**
 * @author Simon André <smn.andre@gmail.com>
 *
 * @experimental
 */
final class Escaper implements EscaperInterface
{
    public function escape(string $value, string $strategy = EscaperInterface::STRATEGY_HTML): string
    {
        return match ($strategy) {
            EscaperInterface::STRATEGY_HTML => self::html($value),
            EscaperInterface::STRATEGY_HTML_ATTR => self::htmlAttr($value),
            EscaperInterface::STRATEGY_JSON => self::json($value),
            EscaperInterface::STRATEGY_JS => self::js($value),
            default => throw new \RuntimeException(sprintf('Invalid strategy "%s" provided', $strategy)),
        };
    }

    /**
     * In HTML, there are characters that have special meaning, such as <, >, ", and &.
     * To display these characters as text, they must be escaped using entities.
     */
    private static function html(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }

    /**
     * In HTML attributes, there are characters that have special meaning, such as ", ', and &.
     * To display these characters as text, they must be escaped using entities.
     */
    private static function htmlAttr(string $value): string
    {
        return str_replace(
            '&apos;',
            '&#039;',
            htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
        );
    }

    /**
     * In JS, there are characters that have special meaning, such as ', ", and \.
     * To display these characters as text, they must be escaped using a backslash.
     */
    private static function js(string $value): string
    {
        // Convert special characters to Unicode
        $escaped = json_encode($value, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

        // Strip surrounding quotes added by json_encode()
        $escaped = substr($escaped, 1, -1);

        // Ensure forward slashes (`/`) are properly escaped (`\/`)
        $escaped = str_replace('/', '\/', $escaped);

        // Convert `\u003C` and `\u003E` back to `<` and `>`
        return str_replace(['\u003C', '\u003E'], ['<', '>'], $escaped);
    }

    /**
     * In JSON, there are characters that have special meaning, such as ", \, and control characters.
     * To display these characters as text, they must be escaped using a backslash.
     */
    private static function json(string $value): string
    {
        // Prevent double-encoding: Only encode if not already JSON
        return ($value[0] === '{' || $value[0] === '[')
            ? $value
            : json_encode($value, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }

}
