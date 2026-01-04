<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Attribute;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Attribute\Attributes;
use Symfony\UX\Html\Attribute\PrefixedAttributes;

enum PrefixedTestEnum: string
{
    case Label = 'label';
    case Hidden = 'hidden';
}

#[CoversClass(PrefixedAttributes::class)]
final class PrefixedAttributesTest extends TestCase
{
    public function testDefaultNormalizerConvertsCamelCaseKeys(): void
    {
        $collection = Attributes::create();
        $prefixed = new PrefixedAttributes($collection, 'data-');
        $updated = $prefixed->set('fooBar', 'baz');

        $this->assertSame('baz', $updated->get('data-foo-bar'));
        $this->assertSame(['foo-bar' => 'baz'], (new PrefixedAttributes($updated, 'data-'))->all());
    }

    public function testCustomNormalizerIsApplied(): void
    {
        $collection = Attributes::create();
        $prefixed = new PrefixedAttributes($collection, 'data-', static fn(string $key): string => strtoupper($key));
        $updated = $prefixed->set('fooBar', 'baz');

        $this->assertSame('baz', $updated->get('data-FOOBAR'));
        $this->assertSame(['FOOBAR' => 'baz'], (new PrefixedAttributes($updated, 'data-', static fn(string $key): string => strtoupper($key)))->all());
    }

    public function testWithChainsAndAcceptsEnums(): void
    {
        $prefixed = new PrefixedAttributes(Attributes::create(), 'aria-');

        $chained = $prefixed
            ->with(PrefixedTestEnum::Label, 'Close')
            ->with(PrefixedTestEnum::Hidden, true);

        $this->assertSame('Close', $chained->attributes()->get('aria-label'));
        $this->assertTrue($chained->attributes()->get('aria-hidden'));
    }
}
