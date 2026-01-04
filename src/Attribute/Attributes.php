<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Attribute;

use Symfony\UX\Html\Renderer\AttributeRenderer;
use Symfony\UX\Html\Renderer\AttributeRendererInterface;
use Symfony\UX\Html\Util\StringUtil;

/**
 * @author Simon André <smn.andre@gmail.com>
 *
 * @experimental
 */
final class Attributes implements AttributesInterface
{
    /**
     * @var array<string, string|bool|null>
     */
    private readonly array $attributes;
    private AttributeRendererInterface $renderer;
    private bool $magicMethodsEnabled;
    /**
     * @param array<string, string|bool|null> $attributes Initial attribute set
     *
     * Boolean values behave as follows:
     *  - `true`  adds the attribute without a value (e.g. disabled)
     *  - `false` or `null` removes the attribute
     *
     * Arrays are not accepted. Join any array of tokens into a string before
     * passing it to this constructor.
     */
    public function __construct(array $attributes = [], ?AttributeRendererInterface $renderer = null, bool $magicMethodsEnabled = false)
    {
        $this->attributes = $attributes;
        $this->renderer = $renderer ?? new AttributeRenderer();
        $this->magicMethodsEnabled = $magicMethodsEnabled;
    }

    /**
     * Factory helper that mirrors the constructor.
     *
     * @param array<string, string|bool|null> $attributes Initial attribute set
     */
    public static function create(array $attributes = [], ?AttributeRendererInterface $renderer = null, bool $magicMethodsEnabled = false): self
    {
        return new static($attributes, $renderer, $magicMethodsEnabled);
    }

    /**
     * Create or replace an attribute.
     *
     * Boolean values:
     *  - `true`  adds the attribute name only.
     *  - `false` or `null` removes the attribute.
     *
     * Arrays should be converted to a space-separated string before calling
     * this method.
     */
    public function set(string $name, string|bool|null $value): self
    {
        $newAttributes = $this->attributes;
        $existing = $newAttributes[$name] ?? null;
        $newAttributes[$name] = $value;

        return new static($newAttributes, $this->renderer, $this->magicMethodsEnabled);
    }

    /**
     * Append a value to an existing attribute or create it when missing.
     *
     * When both the existing and new values are strings, the values are
     * concatenated with a single space. Use this to accumulate CSS classes or
     * other space separated attributes.
     *
     * Boolean values follow the same rules as {@see set()}.
     * Arrays should be joined into a string before calling this method.
     */
    public function add(string $name, string|bool|null $value): self
    {
        $newAttributes = $this->attributes;
        $existing = $newAttributes[$name] ?? null;
        if (true === array_key_exists($name, $newAttributes)) {
            $existing = $newAttributes[$name];
            if (true === is_string($existing) && true === is_string($value)) {
                $value = trim($existing . ' ' . $value);
            }
        }
        $newAttributes[$name] = $value;

        return new static($newAttributes, $this->renderer, $this->magicMethodsEnabled);
    }

    /**
     * Remove an attribute from the collection.
     */
    public function remove(string $name): self
    {
        $newAttributes = $this->attributes;
        if (true === isset($newAttributes[$name])) {
            unset($newAttributes[$name]);
        }

        return new static($newAttributes, $this->renderer, $this->magicMethodsEnabled);
    }

    /**
     * Conditionally add or remove an attribute.
     *
     * When `$condition` is `true`, the attribute is set to `true`.
     * When `false`, the attribute is removed.
     */
    public function toggle(string $name, bool $condition): self
    {
        if (true === $condition) {
            return $this->set($name, true);
        }

        return $this->remove($name);
    }

    /**
     * Retrieve the raw value for an attribute or `null` when missing.
     */
    public function get(string $name): string|bool|null
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * Return all attribute name/value pairs.
     *
     * @return array<string, string|bool|null>
     */
    public function all(): array
    {
        return $this->attributes;
    }

    /**
     * Render the attribute collection as an escaped HTML string.
     */
    public function render(): string
    {
        return $this->renderer->renderAttributes($this->attributes);
    }

    /**
     * Allow the object to be cast to a string using {@see render()}.
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Access the ARIA namespaced helper.
     */
    public function aria(): AriaAttributes
    {
        return new AriaAttributes($this);
    }

    /**
     * Access the Stimulus namespaced helper.
     */
    public function stimulus(): StimulusAttributes
    {
        return new StimulusAttributes($this);
    }

    /**
     * Access generic data attributes helper.
     */
    public function data(): DataAttributes
    {
        return new DataAttributes($this);
    }

    public function enableMagicMethods(bool $enabled = true): self
    {
        return new static($this->attributes, $this->renderer, $enabled);
    }

    /**
     * Magic method fallback.
     *
     * Converts a camelCase method name to kebab-case and calls {@see set()}.
     * Passing `false` removes the attribute while `true` adds it without a value.
     *
     * Example: `disabled(false)` becomes `set('disabled', false)` and
     * `foo('bar')` becomes `set('foo', 'bar')`.
     *
     * @param array<int, string|bool|null> $arguments
     */
    public function __call(string $method, array $arguments): self
    {
        if (false === $this->magicMethodsEnabled) {
            throw new \BadMethodCallException(sprintf('Method "%s" does not exist.', $method));
        }

        $attribute = StringUtil::camelCaseToKebabCase($method);
        if (isset($arguments[0]) && $arguments[0] === false) {
            return $this->remove($attribute);
        }

        return $this->set($attribute, $arguments[0] ?? true);
    }

}
