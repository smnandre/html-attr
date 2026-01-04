<?php

declare(strict_types=1);

namespace Symfony\UX\Html\Attribute;

final class StimulusAttributes extends DataAttributes
{
    public function __construct(AttributesInterface $attributes)
    {
        parent::__construct($attributes);
    }

    public function setController(string $value): AttributesInterface
    {
        return $this->attributes->set('data-controller', $value);
    }

    public function addController(string $value): AttributesInterface
    {
        return $this->attributes->add('data-controller', $value);
    }

    public function removeController(string $value): AttributesInterface
    {
        $current = $this->attributes->get('data-controller');
        if (true === is_string($current)) {
            $controllers = array_filter(explode(' ', $current));
            $newControllers = array_filter($controllers, fn($ctrl) => $ctrl !== $value);
            if ([] === $newControllers) {
                return $this->attributes->remove('data-controller');
            }

            $newValue = implode(' ', $newControllers);
            return $this->attributes->set('data-controller', $newValue);
        }
        return $this->attributes;
    }

    public function toggleController(string $value, bool $condition): AttributesInterface
    {
        if (true === $condition) {
            return $this->addController($value);
        }
        return $this->removeController($value);
    }
}
