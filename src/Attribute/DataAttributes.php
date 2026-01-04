<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Attribute;

/**
 * @author Simon André <smn.andre@gmail.com>
 *
 * @experimental
 *
 * @extends PrefixedAttributes<string|bool|null>
 */
class DataAttributes extends PrefixedAttributes
{
    public function __construct(AttributesInterface $attributes, ?callable $normalizer = null)
    {
        parent::__construct($attributes, 'data-', $normalizer);
    }
}
