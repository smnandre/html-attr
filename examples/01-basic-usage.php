<?php

declare(strict_types=1);

/**
 * Example 1: Basic Usage
 *
 * Demonstrates core attribute manipulation methods.
 */

require __DIR__ . '/../vendor/autoload.php';

use Symfony\UX\Html\Attribute\Attributes;

echo "=== Example 1: Basic Usage ===\n\n";

// Creating attributes
$attrs = Attributes::create()
    ->set('id', 'my-button')
    ->set('class', 'btn')
    ->add('class', 'btn-primary')  // Appends to class
    ->toggle('disabled', true)     // Conditional attribute
    ->set('title', 'Click me!');

echo "Button attributes:\n";
echo '<button' . $attrs->render() . '>Submit</button>' . "\n\n";

// Immutability demonstration
$original = Attributes::create()->set('class', 'original');
$modified = $original->set('class', 'modified');

echo "Immutability check:\n";
echo "Original: " . $original->render() . "\n";
echo "Modified: " . $modified->render() . "\n\n";

// Working with get() and all()
$attrs = Attributes::create()
    ->set('id', 'example')
    ->set('class', 'card')
    ->set('disabled', true);

echo "Retrieving values:\n";
echo "ID: " . $attrs->get('id') . "\n";
echo "Class: " . $attrs->get('class') . "\n";
echo "Disabled: " . ($attrs->get('disabled') ? 'yes' : 'no') . "\n";
echo "All: " . print_r($attrs->all(), true) . "\n";
