<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Merge;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Attribute\Merge\ClassMergeStrategy;
use Symfony\UX\Html\Attribute\Merge\DefaultMergeStrategy;
use Symfony\UX\Html\Attribute\Merge\MergeStrategyRegistry;

#[CoversClass(MergeStrategyRegistry::class)]
#[CoversClass(DefaultMergeStrategy::class)]
final class MergeStrategyRegistryTest extends TestCase
{
    public function testReturnsDefaultStrategyWhenNoneRegistered(): void
    {
        $registry = new MergeStrategyRegistry();
        $strategy = $registry->getStrategy('unknown');
        $this->assertInstanceOf(DefaultMergeStrategy::class, $strategy);
        $this->assertSame('new', $strategy->merge('foo', 'old', 'new'));
    }

    public function testRegisteredStrategyIsReturned(): void
    {
        $registry = new MergeStrategyRegistry();
        $registry->register('class', new ClassMergeStrategy());

        $strategy = $registry->getStrategy('class');
        $this->assertInstanceOf(ClassMergeStrategy::class, $strategy);
        $this->assertSame('a b', $strategy->merge('class', 'a', 'b'));
    }
}
