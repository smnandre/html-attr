<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Attribute;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Attribute\AriaAttributes;
use Symfony\UX\Html\Attribute\Attributes;
use Symfony\UX\Html\Attribute\DataAttributes;
use Symfony\UX\Html\Attribute\StimulusAttributes;

#[CoversClass(Attributes::class)]
final class AttributesTest extends TestCase
{
    public function testSetAndGetAttribute(): void
    {
        $attributes = Attributes::create()->set('id', 'test');

        $this->assertSame('test', $attributes->get('id'));
    }

    public function testAddAttribute(): void
    {
        $attributes = Attributes::create()->set('class', 'btn');
        $attributes = $attributes->add('class', 'btn-primary');

        $this->assertSame('btn btn-primary', $attributes->get('class'));
    }

    public function testRemoveAttribute(): void
    {
        $attributes = Attributes::create()->set('title', 'Example');
        $attributes = $attributes->remove('title');

        $this->assertNull($attributes->get('title'));
    }

    public function testToggleAttribute(): void
    {
        $attributes = Attributes::create()->toggle('disabled', true);
        $this->assertTrue($attributes->get('disabled'));

        $attributes = $attributes->toggle('disabled', false);
        $this->assertNull($attributes->get('disabled'));
    }

    public function testAllAttributes(): void
    {
        $attributes = new Attributes(['class' => 'btn', 'disabled' => true]);
        $result = $attributes->all();

        $this->assertSame(['class' => 'btn', 'disabled' => true], $result);
    }

    public function testAllAttributesEmpty(): void
    {
        $attributes = new Attributes();
        $result = $attributes->all();

        $this->assertSame([], $result);
    }

    public function testRender(): void
    {
        $attributes = Attributes::create()
            ->set('id', 'test')
            ->set('disabled', true)
            ->set('title', 'Example');
        $rendered = $attributes->render();

        $this->assertStringContainsString('id="test"', $rendered);
        $this->assertStringContainsString('disabled', $rendered);
        $this->assertStringContainsString('title="Example"', $rendered);
    }

    public function testToStringUsesRender(): void
    {
        $attributes = Attributes::create()->set('id', 'foo');

        $this->assertSame($attributes->render(), (string) $attributes);
    }

    public function testHelperFactoriesExposeNamespacedBuilders(): void
    {
        $attributes = Attributes::create();

        $this->assertInstanceOf(AriaAttributes::class, $attributes->aria());
        $this->assertInstanceOf(StimulusAttributes::class, $attributes->stimulus());
        $this->assertInstanceOf(DataAttributes::class, $attributes->data());
    }
}
