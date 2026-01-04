<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Attribute;

/**
 * @template T of string|bool|null
 *
 * @author Simon André <smn.andre@gmail.com>
 */
interface NamespacedAttributesInterface
{
    /**
     * Set a namespaced attribute within the underlying collection.
     */
    public function set(string|\BackedEnum $key, string|bool|null $value): AttributesInterface;

    /**
     * Retrieve a namespaced attribute value.
     */
    public function get(string|\BackedEnum $key): string|bool|null;

    /**
     * Return all values for the namespace.
     *
     * @return array<string, string|bool|null>
     */
    public function all(): array;
}
