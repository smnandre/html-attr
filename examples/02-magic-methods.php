<?php

declare(strict_types=1);

/**
 * Example 2: Magic Methods (DX-Oriented API)
 *
 * Demonstrates the fluent magic method API for improved developer experience.
 */

require __DIR__ . '/../vendor/autoload.php';

use Symfony\UX\Html\Attribute\Attributes;

echo "=== Example 2: Magic Methods ===\n\n";

// Enable magic methods
$attrs = Attributes::create()
    ->enableMagicMethods()
    ->id('user-profile')
    ->class('card shadow-lg')
    ->dataUserId('12345')           // Converts to data-user-id
    ->ariaLabel('User profile')     // Converts to aria-label
    ->tabindex(0)
    ->title('View profile');

echo "Magic method result:\n";
echo '<div' . $attrs->render() . '>Content</div>' . "\n\n";

// Boolean attributes
$isDisabled = true;
$attrs = Attributes::create()
    ->enableMagicMethods()
    ->disabled($isDisabled)         // true = add attribute
    ->readonly(false)               // false = remove attribute
    ->required(true);

echo "Boolean attributes:\n";
echo '<input' . $attrs->render() . ' />' . "\n\n";

// Complex example: Button with Stimulus
$attrs = Attributes::create()
    ->enableMagicMethods()
    ->class('btn btn-primary')
    ->type('button')
    ->dataController('modal')
    ->dataAction('click->modal#open')
    ->dataModalUrlValue('/users/123');

echo "Stimulus controller:\n";
echo '<button' . $attrs->render() . '>Open Modal</button>' . "\n";
