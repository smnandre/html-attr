<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Html;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\HtmlBundle;

#[CoversClass(HtmlBundle::class)]
final class HtmlBundleTest extends TestCase
{
    public function testGetPathReturnsBundleDirectory(): void
    {
        $bundle = new HtmlBundle();
        $reflection = new \ReflectionClass(HtmlBundle::class);

        $this->assertSame(\dirname($reflection->getFileName()), $bundle->getPath());
    }
}
