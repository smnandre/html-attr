<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Twig;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Twig\HtmlTwigExtension;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

#[CoversClass(HtmlTwigExtension::class)]
final class HtmlTwigExtensionTest extends TestCase
{
    public function testAttributesFunctionRenders(): void
    {
        $twig = new Environment(new ArrayLoader([
            'index' => '{{ attributes().class("btn").render()|raw }}',
        ]));
        $twig->addExtension(new HtmlTwigExtension());

        $output = $twig->render('index');

        $this->assertSame(' class="btn"', $output);
    }
}
