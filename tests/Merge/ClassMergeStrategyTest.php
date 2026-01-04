<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Merge;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Attribute\Merge\ClassMergeStrategy;

#[CoversClass(ClassMergeStrategy::class)]
final class ClassMergeStrategyTest extends TestCase
{
    public function testMergeStringClasses(): void
    {
        $strategy = new ClassMergeStrategy();
        $merged = $strategy->merge('class', 'p-2 m-2', 'p-2 text-lg');
        $this->assertSame('p-2 m-2 text-lg', $merged);
    }

    public function testMergeNonStringValuesReturnsNew(): void
    {
        $strategy = new ClassMergeStrategy();
        $merged = $strategy->merge('class', ['p-2'], ['m-2']);
        $this->assertSame(['m-2'], $merged);
    }
}
