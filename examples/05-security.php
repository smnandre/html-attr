<?php

declare(strict_types=1);

/**
 * Example 5: Security & Escaping
 *
 * Demonstrates automatic XSS prevention and proper escaping.
 */

require __DIR__ . '/../vendor/autoload.php';

use Symfony\UX\Html\Attribute\Attributes;

echo "=== Example 5: Security & Escaping ===\n\n";

// Automatic escaping of dangerous characters
echo "1. XSS Prevention:\n";
$maliciousInput = '\"><script>alert(\"XSS\")</script><div class=\"';

$attrs = Attributes::create()
    ->set('class', $maliciousInput)
    ->set('title', '<img src=x onerror=alert(1)>');

echo "Raw input: {$maliciousInput}\n";
echo "Escaped output:\n";
echo '<div' . $attrs->render() . '>Safe</div>' . "\n\n";

// Unicode handling
echo "2. Unicode Characters:\n";
$attrs = Attributes::create()
    ->set('title', '🎉 Celebration!')
    ->set('data-message', '你好世界')
    ->set('aria-label', 'Emoji:  😀');

echo '<div' . $attrs->render() . '>Unicode</div>' . "\n\n";

// Special HTML entities
echo "3. HTML Entities:\n";
$attrs = Attributes::create()
    ->set('title', 'A < B && C > D')
    ->set('data-expression', '5 < 10 && 15 > 10');

echo '<div' . $attrs->render() . '>Entities</div>' . "\n\n";

// Safe with user input
echo "4. User Input (Simulated):\n";
$userInput = $_GET['name'] ?? '<script>alert(\"pwned\")</script>';

$attrs = Attributes::create()
    ->set('data-username', $userInput)
    ->set('title', "User: {$userInput}");

echo "User provided: {$userInput}\n";
echo '<div' . $attrs->render() . '>Profile</div>' . "\n";
