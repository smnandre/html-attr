<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Attribute;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Attribute\Attributes;
use Symfony\UX\Html\Attribute\StimulusAttributes;

#[CoversClass(StimulusAttributes::class)]
final class StimulusAttributesTest extends TestCase
{
    public function testSetAndGetStimulusAttribute(): void
    {
        $attributes = Attributes::create();
        $stimulus = $attributes->stimulus();
        $attributes = $stimulus->set('controller', 'example');

        $this->assertInstanceOf(Attributes::class, $attributes);

        $stimulus = $attributes->stimulus();

        $this->assertSame('example', $stimulus->get('controller'));
    }

    public function testCamelCaseAttributeIsNormalized(): void
    {
        $attributes = Attributes::create();
        $stimulus = $attributes->stimulus();
        $attributes = $stimulus->set('fooBar', 'baz');

        $this->assertInstanceOf(Attributes::class, $attributes);

        $this->assertSame('baz', $attributes->get('data-foo-bar'));
    }

    public function testAddController(): void
    {
        $attributes = Attributes::create();
        $stimulus = new StimulusAttributes($attributes);
        $attributes = $stimulus->setController('first');
        $this->assertInstanceOf(Attributes::class, $attributes);

        $stimulus = new StimulusAttributes($attributes);
        $attributes = $stimulus->addController('second');
        $this->assertInstanceOf(Attributes::class, $attributes);

        $stimulus = new StimulusAttributes($attributes);

        $this->assertSame('first second', $stimulus->get('controller'));
        $this->assertSame('first second', $attributes->get('data-controller'));
    }

    public function testRemoveController(): void
    {
        $attributes = Attributes::create()->set('data-controller', 'first second');
        $stimulus = new StimulusAttributes($attributes);
        $attributes = $stimulus->removeController('first');
        $this->assertInstanceOf(Attributes::class, $attributes);

        $this->assertSame('second', $attributes->get('data-controller'));
    }

    public function testRemoveControllerWhenAttributeMissingKeepsCollection(): void
    {
        $attributes = Attributes::create();
        $stimulus = new StimulusAttributes($attributes);

        $result = $stimulus->removeController('missing');

        $this->assertSame($attributes, $result);
    }

    public function testToggleController(): void
    {
        $attributes = Attributes::create();
        $stimulus = new StimulusAttributes($attributes);
        $attributes = $stimulus->toggleController('ctrl', true);
        $this->assertInstanceOf(Attributes::class, $attributes);
        $stimulus = new StimulusAttributes($attributes);

        $this->assertSame('ctrl', $attributes->get('data-controller'));

        $attributes = $stimulus->toggleController('ctrl', false);
        $this->assertInstanceOf(Attributes::class, $attributes);

        $this->assertNull($attributes->get('data-controller'));
    }
}
