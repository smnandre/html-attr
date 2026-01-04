<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Attribute;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Attribute\Attributes;
use Symfony\UX\Html\Attribute\AriaAttributes;

enum TestAriaAttribute: string
{
    case Label = 'label';
    case Hidden = 'hidden';
}

#[CoversClass(AriaAttributes::class)]
final class AriaAttributesTest extends TestCase
{
    public function testSetAndGetAriaAttribute(): void
    {
        $attributes = Attributes::create();
        $aria = $attributes->aria();
        $attributes = $aria->set('label', 'Test Label');

        $this->assertSame('Test Label', $attributes->get('aria-label'));
    }

    public function testCamelCaseKeyIsNormalized(): void
    {
        $attributes = Attributes::create();
        $aria = $attributes->aria();
        $attributes = $aria->set('labelledBy', 'id1');

        $this->assertSame('id1', $attributes->get('aria-labelled-by'));
    }

    public function testAllAriaAttributes(): void
    {
        $attributes = Attributes::create()
            ->set('aria-label', 'Label')
            ->set('aria-hidden', true);
        $aria = new AriaAttributes($attributes);
        $all = $aria->all();

        $this->assertArrayHasKey('label', $all);
        $this->assertArrayHasKey('hidden', $all);
    }

    public function testGetReturnsNamespacedValue(): void
    {
        $attributes = Attributes::create()->set('aria-expanded', true);
        $aria = new AriaAttributes($attributes);

        $this->assertTrue($aria->get('expanded'));
    }

    public function testSetAcceptsBackedEnumKeys(): void
    {
        $attributes = Attributes::create();
        $aria = $attributes->aria();
        $attributes = $aria->set(TestAriaAttribute::Label, 'Enum Label');

        $this->assertSame('Enum Label', $attributes->get('aria-label'));
    }

    public function testWithSupportsChaining(): void
    {
        $aria = Attributes::create()->aria()
            ->with(TestAriaAttribute::Label, 'Close')
            ->with(TestAriaAttribute::Hidden, true);

        $this->assertSame('Close', $aria->attributes()->get('aria-label'));
        $this->assertTrue($aria->attributes()->get('aria-hidden'));
    }
}
