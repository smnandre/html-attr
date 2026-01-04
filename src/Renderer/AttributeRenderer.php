<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Renderer;

final class AttributeRenderer implements AttributeRendererInterface
{
    public function renderAttribute(string $name, string|bool|null $value): string
    {
        if (null === $value || false === $value) {
            return '';
        }

        $escapedName = htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        if (true === $value) {
            if (str_starts_with($name, 'aria-')) {
                $escapedValue = htmlspecialchars('true', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

                return sprintf(' %s="%s"', $escapedName, $escapedValue);
            }

            return ' ' . $escapedName;
        }
        $escapedValue = htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        return sprintf(' %s="%s"', $escapedName, $escapedValue);
    }

    public function renderAttributes(array $attributes = []): string
    {
        $parts = [];
        foreach ($attributes as $name => $value) {
            $parts[] = $this->renderAttribute($name, $value);
        }

        return implode('', $parts);
    }
}
