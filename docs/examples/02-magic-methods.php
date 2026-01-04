<?php

/**
 * Magic Methods Example
 * 
 * This example demonstrates the DX-oriented API with magic methods.
 */

require __DIR__.'/../vendor/autoload.php';

use Symfony\UX\Html\Attribute\Attributes;

// Enable magic methods for a more convenient API
$attrs = Attributes::create()->enableMagicMethods();

// Use magic methods (camelCase converts to kebab-case)
$button = $attrs
    ->id('my-button')
    ->class('btn btn-lg btn-success')
    ->type('button')
    ->disabled(true)
    ->ariaLabel('Close dialog')
    ->dataAction('click->modal#close');

echo "Button with magic methods:\n";
echo '<button' . $button . '>Close</button>' . "\n\n";
// Output: <button id="my-button" class="btn btn-lg btn-success" type="button" disabled aria-label="Close dialog" data-action="click->modal#close">Close</button>

// Custom data attributes
$element = Attributes::create()->enableMagicMethods()
    ->dataUserId('12345')
    ->dataUserRole('admin')
    ->dataToggle('tooltip');

echo "Element with data attributes:\n";
echo '<div' . $element . '>User info</div>' . "\n\n";
// Output: <div data-user-id="12345" data-user-role="admin" data-toggle="tooltip">User info</div>

// Boolean attributes with magic methods
$input = Attributes::create()->enableMagicMethods()
    ->type('email')
    ->name('user_email')
    ->required(true)
    ->autofocus(true)
    ->readonly(false);  // false removes the attribute

echo "Input with boolean magic methods:\n";
echo '<input' . $input . ' />' . "\n";
// Output: <input type="email" name="user_email" required autofocus />
