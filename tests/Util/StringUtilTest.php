<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Util;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Util\StringUtil;

#[CoversClass(StringUtil::class)]
final class StringUtilTest extends TestCase
{
    public function testCamelCaseToKebabCase(): void
    {
        $result = StringUtil::camelCaseToKebabCase('thisIsATest');
        $this->assertSame('this-is-a-test', $result);
    }

    public function testReturnsCachedResultForPreviouslyConvertedString(): void
    {
        StringUtil::camelCaseToKebabCase('cachedString');
        $result = StringUtil::camelCaseToKebabCase('cachedString');
        $this->assertSame('cached-string', $result);
    }

    public function testHandlesSingleWordWithoutConversion(): void
    {
        $result = StringUtil::camelCaseToKebabCase('word');
        $this->assertSame('word', $result);
    }

    public function testThrowsExceptionForInvalidConversionResult(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Failed to convert camelCase string to kebab-case.');
        StringUtil::camelCaseToKebabCase("\x80InvalidString");
    }
}
