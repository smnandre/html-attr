<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Attribute;

/**
 * @author Simon André <smn.andre@gmail.com>
 *
 * @experimental
 */
interface AttributesInterface
{
    /**
     * Create or replace an attribute.
     *
     * @param string $name  Attribute name
     * @param string|bool|null $value Pass `true` to add the attribute or `false`/`null` to remove it.
     */
    public function set(string $name, string|bool|null $value): self;

    /**
     * Append a value to an existing attribute or create it when missing.
     */
    public function add(string $name, string|bool|null $value): self;

    /**
     * Remove an attribute from the collection.
     */
    public function remove(string $name): self;

    /**
     * Add or remove an attribute based on a condition.
     */
    public function toggle(string $name, bool $condition): self;

    /**
     * Retrieve the value of an attribute or null if not present.
     */
    public function get(string $name): string|bool|null;

    /**
     * Return all attributes as an associative array.
     *
     * @return array<string, string|bool|null>
     */
    public function all(): array;

    /**
     * Render the attributes as an escaped HTML string.
     */
    public function render(): string;
}
