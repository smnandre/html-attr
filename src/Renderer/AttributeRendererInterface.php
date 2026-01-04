<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Renderer;

/**
 * @author Simon André <smn.andre@gmail.com>
 *
 * @experimental
 */
interface AttributeRendererInterface
{
    /**
     * @param string|bool|null $value
     */
    public function renderAttribute(string $name, string|bool|null $value): string;

    /**
     * @param array<string, string|bool|null> $attributes
     */
    public function renderAttributes(array $attributes = []): string;
}
