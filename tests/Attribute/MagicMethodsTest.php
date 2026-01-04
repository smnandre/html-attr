<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Attribute;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Attribute\Attributes;

#[CoversClass(Attributes::class)]
final class MagicMethodsTest extends TestCase
{
    public function testDisabledFalseRemovesAttribute(): void
    {
        $base = Attributes::create()->enableMagicMethods();
        $attributes = $base->__call('disabled', [false]);
        $this->assertNull($attributes->get('disabled'));

        $rendered = $attributes->render();
        $this->assertStringNotContainsString('disabled', $rendered);
    }

    public function testDisabledTrueRendersAttribute(): void
    {
        $base = Attributes::create()->enableMagicMethods();
        $attributes = $base->__call('disabled', [true]);
        $this->assertTrue($attributes->get('disabled'));

        $rendered = $attributes->render();
        $this->assertStringContainsString('disabled', $rendered);
    }

    public function testGenericMagicMethodFoo(): void
    {
        $base = Attributes::create()->enableMagicMethods();
        $attributes = $base->__call('foo', ['bar']);
        $this->assertSame('bar', $attributes->get('foo'));
        $rendered = $attributes->render();

        $this->assertStringContainsString('foo="bar"', $rendered);
    }

    public function testGenericCamelCaseMethodIsNormalized(): void
    {
        $base = Attributes::create()->enableMagicMethods();
        $attributes = $base->__call('fooBar', ['baz']);

        $this->assertSame('baz', $attributes->get('foo-bar'));
    }

    public function testAriaMagicMethod(): void
    {
        $base = Attributes::create()->enableMagicMethods();
        $attributes = $base->__call('ariaLabel', ['Accessible Label']);
        $this->assertSame('Accessible Label', $attributes->get('aria-label'));

        $rendered = $attributes->render();
        $this->assertStringContainsString('aria-label="Accessible Label"', $rendered);
    }

    public function testToStringUsesRender(): void
    {
        $base = Attributes::create()->enableMagicMethods();
        $attributes = $base->__call('foo', ['bar']);

        $this->assertSame($attributes->render(), (string) $attributes);
    }

    public function testMagicMethodsDisabledByDefault(): void
    {
        $attributes = Attributes::create();
        $this->expectException(\BadMethodCallException::class);

        $attributes->__call('foo', ['bar']);
    }
}
