<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Attribute\Merge;

/**
 * @author Simon André <smn.andre@gmail.com>
 *
 * @experimental
 */
interface MergeStrategyInterface
{
    public function merge(string $name, mixed $existingValue, mixed $newValue): mixed;
}
