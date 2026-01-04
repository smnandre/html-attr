<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Tests\Renderer;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Html\Attribute\Attributes;
use Symfony\UX\Html\Renderer\AttributeRenderer;

#[CoversClass(AttributeRenderer::class)]
class AttributeRendererTest extends TestCase
{
    public function testRender(): void
    {
        $renderer = new AttributeRenderer();

        $output = $renderer->renderAttributes([]);
        $this->assertSame('', $output, 'Empty attributes should render as an empty string.');

        $output = $renderer->renderAttribute('id', 'test');
        $this->assertSame(' id="test"', $output, 'A string attribute should render correctly.');

        $output = $renderer->renderAttribute('disabled', true);
        $this->assertSame(' disabled', $output, 'Non-ARIA boolean true should render as a valueless attribute.');

        $output = $renderer->renderAttribute('aria-hidden', true);
        $this->assertSame(' aria-hidden="true"', $output, 'ARIA boolean true should render as "true".');
    }

    public function testRenderWithAttributes(): void
    {
        $renderer = new AttributeRenderer();
        $attributes = [
            'id' => 'test',
            'disabled' => true,
            'aria-hidden' => true,
            'class' => 'btn btn-primary',
        ];
        $expected = ' id="test" disabled aria-hidden="true" class="btn btn-primary"';
        $output = $renderer->renderAttributes($attributes);
        $this->assertSame($expected, $output, 'The attributes should be rendered as a single string with proper spacing and escaping.');
    }

    public function testRenderSkipsNullAndFalseValues(): void
    {
        $renderer = new AttributeRenderer();

        $this->assertSame('', $renderer->renderAttribute('hidden', null));
        $this->assertSame('', $renderer->renderAttribute('hidden', false));
    }

    public function testAttributeValuesAreEscaped(): void
    {
        $attributes = Attributes::create()
            ->set('onclick', 'alert("XSS")')
            ->set('title', '<script>alert("XSS")</script>');

        $rendered = $attributes->render();

        $this->assertStringContainsString('onclick="alert(&quot;XSS&quot;)"', $rendered);
        $this->assertStringContainsString('&lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;', $rendered);
        $this->assertStringNotContainsString('<script>', $rendered);
    }

    public function testAttributeNamesAreEscaped(): void
    {
        $attributes = Attributes::create()
            ->set('"><script>alert(1)</script>', 'value');

        $rendered = $attributes->render();

        $this->assertStringNotContainsString('<script>', $rendered);
        $this->assertStringContainsString('&lt;script&gt;alert(1)&lt;/script&gt;="value"', $rendered);
    }
}
