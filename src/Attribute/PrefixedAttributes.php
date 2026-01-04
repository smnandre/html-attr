<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Attribute;

use InvalidArgumentException;
use Symfony\UX\Html\Util\StringUtil;

/**
 * @template TValue of string|bool|null
 * @implements NamespacedAttributesInterface<TValue>
 *
 * @experimental
 */
class PrefixedAttributes implements NamespacedAttributesInterface
{
    /**
     * @var callable(string):string
     */
    private $normalizer;

    public function __construct(
        protected AttributesInterface $attributes,
        private readonly string $prefix,
        ?callable $normalizer = null,
    )
    {
        $this->normalizer = $normalizer ?? StringUtil::camelCaseToKebabCase(...);
    }

    public function set(string|\BackedEnum $key, string|bool|null $value): AttributesInterface
    {
        return $this->attributes->set($this->attributeName($key), $value);
    }

    public function get(string|\BackedEnum $key): string|bool|null
    {
        return $this->attributes->get($this->attributeName($key));
    }

    public function all(): array
    {
        $result = [];
        $length = strlen($this->prefix);

        foreach ($this->attributes->all() as $name => $value) {
            if (true === str_starts_with($name, $this->prefix)) {
                $result[substr($name, $length)] = $value;
            }
        }

        return $result;
    }

    public function with(string|\BackedEnum $key, string|bool|null $value): static
    {
        $updatedAttributes = $this->set($key, $value);
        $clone = clone $this;
        $clone->attributes = $updatedAttributes;

        return $clone;
    }

    public function attributes(): AttributesInterface
    {
        return $this->attributes;
    }

    private function attributeName(string|\BackedEnum $key): string
    {
        return $this->prefix.$this->normalize($key);
    }

    private function normalize(string|\BackedEnum $key): string
    {
        if (is_string($key)) {
            return ($this->normalizer)($key);
        }
        
        if (!is_string($key->value)) {
            throw new InvalidArgumentException('Argument $key must be a string BackedEnum, or a string.');
        }

        return ($this->normalizer)($key->value);
    }
}
