<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Attribute;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Attribute\Attributes;

#[CoversClass(Attributes::class)]
final class AttributesEdgeCasesTest extends TestCase
{
    public function testEmptyAttributeName(): void
    {
        $attributes = Attributes::create()->set('', 'value');

        $this->assertSame('value', $attributes->get(''));
        $this->assertStringContainsString('="value"', $attributes->render());
    }

    public function testVeryLongAttributeValue(): void
    {
        $longValue = str_repeat('a', 10000);
        $attributes = Attributes::create()->set('data-long', $longValue);

        $this->assertSame($longValue, $attributes->get('data-long'));
        $this->assertStringContainsString($longValue, $attributes->render());
    }

    public function testUnicodeInAttributes(): void
    {
        $attributes = Attributes::create()->set('title', '你好世界 🌍');

        $rendered = $attributes->render();
        $this->assertStringContainsString('你好世界 🌍', $rendered);
    }

    public function testMultipleSpacesInClass(): void
    {
        $attributes = Attributes::create()
            ->set('class', 'btn    btn-primary');

        $rendered = $attributes->render();
        $this->assertStringContainsString('class="btn    btn-primary"', $rendered);
    }

    public function testAttributeNameWithNumbers(): void
    {
        $attributes = Attributes::create()->set('data-id-123', 'value');

        $this->assertSame('value', $attributes->get('data-id-123'));
    }

    public function testAttributeWithNewline(): void
    {
        $attributes = Attributes::create()->set('title', "Line 1\nLine 2");

        $rendered = $attributes->render();
        $this->assertStringContainsString('title=', $rendered);
    }

    public function testAddToNonExistentAttribute(): void
    {
        $attributes = Attributes::create()->add('class', 'btn');

        $this->assertSame('btn', $attributes->get('class'));
    }

    public function testToggleMultipleTimes(): void
    {
        $attributes = Attributes::create()
            ->toggle('disabled', true)
            ->toggle('disabled', false)
            ->toggle('disabled', true);

        $this->assertTrue($attributes->get('disabled'));
    }

    public function testRemoveNonExistentAttribute(): void
    {
        $attributes = Attributes::create()->remove('non-existent');

        $this->assertNull($attributes->get('non-existent'));
    }

    public function testChainManyOperations(): void
    {
        $attributes = Attributes::create();
        for ($i = 0; $i < 100; $i++) {
            $attributes = $attributes->add('class', 'class-' . $i);
        }

        $rendered = $attributes->render();
        $this->assertStringContainsString('class-0', $rendered);
        $this->assertStringContainsString('class-99', $rendered);
    }

    public function testAttributeWithOnlyWhitespace(): void
    {
        $attributes = Attributes::create()->set('title', '   ');

        $this->assertSame('   ', $attributes->get('title'));
    }

    public function testBooleanFalseRemovesAttribute(): void
    {
        $attributes = Attributes::create()
            ->set('disabled', true)
            ->set('disabled', false);

        $this->assertFalse($attributes->get('disabled'));
    }

    public function testNullRemovesAttribute(): void
    {
        $attributes = Attributes::create()
            ->set('title', 'value')
            ->set('title', null);

        $this->assertNull($attributes->get('title'));
    }
}
