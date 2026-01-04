<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Attribute;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Attribute\Attributes;
use Symfony\UX\Html\Attribute\DataAttributes;

#[CoversClass(DataAttributes::class)]
final class DataAttributesTest extends TestCase
{
    public function testSetAndGetDataAttribute(): void
    {
        $attributes = Attributes::create();
        $data = $attributes->data();
        $attributes = $data->set('foo', 'bar');
        $this->assertInstanceOf(Attributes::class, $attributes);

        $data = $attributes->data();
        $this->assertSame('bar', $data->get('foo'));
    }

    public function testCamelCaseAttributeIsNormalized(): void
    {
        $attributes = Attributes::create();
        $data = $attributes->data();
        $attributes = $data->set('fooBar', 'baz');
        $this->assertInstanceOf(Attributes::class, $attributes);

        $data = $attributes->data();
        $this->assertSame('baz', $attributes->get('data-foo-bar'));
    }

    public function testAllDataAttributes(): void
    {
        $attributes = Attributes::create()
            ->set('data-foo', 'bar')
            ->set('data-baz', 'qux');
        $data = new DataAttributes($attributes);
        $all = $data->all();

        $this->assertArrayHasKey('foo', $all);
        $this->assertArrayHasKey('baz', $all);
    }
}
