<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Attribute\Merge;

/**
 * @author Simon André <smn.andre@gmail.com>
 *
 * @experimental
 */
final class MergeStrategyRegistry
{
    /**
     * @var array<string, MergeStrategyInterface>
     */
    private array $strategies = [];

    public function register(string $attributeName, MergeStrategyInterface $strategy): void
    {
        $this->strategies[$attributeName] = $strategy;
    }

    public function getStrategy(string $name): MergeStrategyInterface
    {
        return $this->strategies[$name] ?? new DefaultMergeStrategy();
    }
}
