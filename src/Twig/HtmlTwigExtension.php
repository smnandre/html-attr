<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Twig;

use Symfony\UX\Html\Attribute\Attributes;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class HtmlTwigExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'attributes',
                /**
                 * @param array<string, string|bool|null> $attributes
                 */
                static fn(array $attributes = []) => Attributes::create($attributes, null, true),
                ['is_safe' => ['html']],
            ),
        ];
    }
}
