<?php

declare(strict_types=1);

/**
 * Example 4: Extensions
 *
 * Demonstrates the extension system for custom attribute processing.
 */

require __DIR__ . '/../vendor/autoload.php';

use Symfony\UX\Html\Attribute\Attributes;
use Symfony\UX\Html\Extension\ExtensionManager;
use Symfony\UX\Html\Extension\StyleMergeExtension;
use Symfony\UX\Html\Extension\TailwindMergeExtension;

echo "=== Example 4: Extensions ===\n\n";

// Without extensions
echo "1. Without Extensions (duplicate styles):\n";
$attrs = Attributes::create()
    ->add('style', 'color: red;')
    ->add('style', 'margin: 10px;')
    ->add('style', 'color: blue;');  // Should override red

echo '<div' . $attrs->render() . '>Text</div>' . "\n\n";

// With StyleMergeExtension
echo "2. With StyleMergeExtension (merged intelligently):\n";
$manager = new ExtensionManager();
$manager->register(new StyleMergeExtension());

$attrs = Attributes::create([], null, $manager)
    ->add('style', 'color: red;')
    ->add('style', 'margin: 10px;')
    ->add('style', 'color: blue;');  // Overrides red

echo '<div' . $attrs->render() . '>Text</div>' . "\n\n";

// Tailwind CSS class merging
echo "3. With TailwindMergeExtension:\n";
$manager = new ExtensionManager();
$manager->register(new TailwindMergeExtension());

$attrs = Attributes::create([], null, $manager)
    ->add('class', 'p-4 m-2')
    ->add('class', 'p-8');  // p-8 should override p-4

echo '<div' . $attrs->render() . '>Tailwind Box</div>' . "\n\n";

// Multiple extensions with priority
echo "4. Multiple Extensions:\n";
$manager = new ExtensionManager();
$manager->register(new TailwindMergeExtension(), priority: 10);
$manager->register(new StyleMergeExtension(), priority: 5);

$attrs = Attributes::create([], null, $manager)
    ->add('class', 'p-4 text-red-500')
    ->add('class', 'p-8 text-blue-500')
    ->add('style', 'margin: 10px;')
    ->add('style', 'padding: 20px;');

echo '<div' . $attrs->render() . '>Complex Example</div>' . "\n";
