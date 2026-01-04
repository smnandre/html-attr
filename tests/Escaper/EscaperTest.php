<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Escaper;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Escaper\Escaper;

#[CoversClass(Escaper::class)]
class EscaperTest extends TestCase
{
    #[DataProvider('provideHtmlCases')]
    public function testEscapeHtml(string $value, string $expected): void
    {
        $this->assertSame($expected, (new Escaper())->escape($value, Escaper::STRATEGY_HTML));
    }

    #[DataProvider('provideHtmlAttrCases')]
    public function testEscapeHtmlAttr(string $value, string $expected): void
    {
        $this->assertSame($expected, (new Escaper())->escape($value, Escaper::STRATEGY_HTML_ATTR));
    }

    #[DataProvider('provideJsCases')]
    public function testEscapeJs(string $value, string $expected): void
    {
        $this->assertSame($expected, (new Escaper())->escape($value, Escaper::STRATEGY_JS));
    }

    #[DataProvider('provideJsonCases')]
    public function testEscapeJson(string $value, string $expected): void
    {
        $this->assertSame($expected, (new Escaper())->escape($value, Escaper::STRATEGY_JSON));
    }

    /**
     * @return iterable<array{string, string}>
     */
    public static function provideHtmlCases(): iterable
    {
        yield ['<div>', '&lt;div&gt;'];
        yield ['"Hello"', '&quot;Hello&quot;'];
        yield ["O'Reilly", 'O&#039;Reilly'];
        yield ['<script>alert(1)</script>', '&lt;script&gt;alert(1)&lt;/script&gt;'];
    }

    /**
     * @return iterable<array{string, string}>
     */
    public static function provideHtmlAttrCases(): iterable
    {
        yield ['"value"', '&quot;value&quot;'];
        yield ["'single'", '&#039;single&#039;'];
        yield ['<input>', '&lt;input&gt;'];
        yield ['onclick="alert(1)"', 'onclick=&quot;alert(1)&quot;'];
    }

    /**
     * @return iterable<array{string, string}>
     */
    public static function provideJsCases(): iterable
    {
        yield ["alert('XSS');", 'alert(\u0027XSS\u0027);'];
        yield ['"quote"', '\u0022quote\u0022'];
        yield ['</script>', '<\/script>'];
        yield ["var a = 'test';", 'var a = \u0027test\u0027;'];
    }

    /**
     * @return iterable<array{string, string}>
     */
    public static function provideJsonCases(): iterable
    {
        yield ['{"key": "value"}', '{"key": "value"}'];
        yield ["O'Reilly", '"O\'Reilly"'];
        yield ['<div>', '"<div>"'];
    }
}
