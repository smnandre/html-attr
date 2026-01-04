<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Merge;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Attribute\Merge\DefaultMergeStrategy;

#[CoversClass(DefaultMergeStrategy::class)]
final class DefaultMergeStrategyTest extends TestCase
{
    public function testMergeReturnsNewValue(): void
    {
        $strategy = new DefaultMergeStrategy();
        $result = $strategy->merge('attr', 'old-value', 'new-value');

        $this->assertSame('new-value', $result);
    }

    public function testMergeWithNull(): void
    {
        $strategy = new DefaultMergeStrategy();
        $result = $strategy->merge('attr', 'old-value', null);

        $this->assertNull($result);
    }

    public function testMergeWithBoolean(): void
    {
        $strategy = new DefaultMergeStrategy();
        $result = $strategy->merge('disabled', false, true);

        $this->assertTrue($result);
    }

    public function testMergeWithArray(): void
    {
        $strategy = new DefaultMergeStrategy();
        $result = $strategy->merge('data', ['old' => 1], ['new' => 2]);

        $this->assertSame(['new' => 2], $result);
    }
}
