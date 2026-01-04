<?php

/**
 * Basic Usage Example
 * 
 * This example demonstrates the core functionality of the Attributes class.
 */

require __DIR__.'/../vendor/autoload.php';

use Symfony\UX\Html\Attribute\Attributes;

// Create a basic button with attributes
$button = Attributes::create()
    ->set('type', 'submit')
    ->set('class', 'btn btn-primary')
    ->set('id', 'submit-button');

echo "Basic button:\n";
echo '<button' . $button . '>Click me</button>' . "\n\n";
// Output: <button type="submit" class="btn btn-primary" id="submit-button">Click me</button>

// Boolean attributes
$input = Attributes::create()
    ->set('type', 'text')
    ->set('name', 'email')
    ->set('required', true)
    ->set('disabled', true);

echo "Input with boolean attributes:\n";
echo '<input' . $input . ' />' . "\n\n";
// Output: <input type="text" name="email" required disabled />

// Adding classes incrementally
$div = Attributes::create()
    ->set('class', 'container')
    ->add('class', 'mt-4')
    ->add('class', 'bg-white');

echo "Div with multiple classes:\n";
echo '<div' . $div . '>Content</div>' . "\n\n";
// Output: <div class="container mt-4 bg-white">Content</div>

// Toggle attributes based on conditions
$isActive = true;
$hasError = false;

$card = Attributes::create()
    ->set('class', 'card')
    ->toggle('active', $isActive)
    ->toggle('error', $hasError);

echo "Card with conditional attributes:\n";
echo '<div' . $card . '>Card content</div>' . "\n";
// Output: <div class="card" active>Card content</div>
