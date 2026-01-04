<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Attribute\Merge;

/**
 * @author Simon André <smn.andre@gmail.com>
 *
 * @experimental
 */
final class ClassMergeStrategy implements MergeStrategyInterface
{
    public function merge(string $name, mixed $existingValue, mixed $newValue): mixed
    {
        if (true === is_string($existingValue) && true === is_string($newValue)) {
            $classes = array_filter(explode(' ', $existingValue));
            $newClasses = array_filter(explode(' ', $newValue));
            $merged = array_unique(array_merge($classes, $newClasses));

            return implode(' ', $merged);
        }

        return $newValue;
    }
}
