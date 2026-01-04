<?php

declare(strict_types=1);

/**
 * Example 3: Namespaced Helpers
 *
 * Demonstrates ARIA, Data, and Stimulus helpers.
 */

require __DIR__ . '/../vendor/autoload.php';

use Symfony\UX\Html\Attribute\Attributes;

echo "=== Example 3: Namespaced Helpers ===\n\n";

// ARIA Attributes
echo "1. ARIA Attributes:\n";
$attrs = Attributes::create()
    ->set('id', 'menu')
    ->set('class', 'dropdown-menu')
    ->aria()->set('label', 'Main navigation')
    ->aria()->set('expanded', true)
    ->aria()->set('haspopup', true);

echo '<nav' . $attrs->render() . '>...</nav>' . "\n\n";

// Data Attributes
echo "2. Data Attributes:\n";
$attrs = Attributes::create()
    ->set('class', 'user-card')
    ->data()->set('user-id', '42')
    ->data()->set('role', 'admin')
    ->data()->set('active', 'true');

echo '<div' . $attrs->render() . '>User Info</div>' . "\n\n";

// Stimulus Helpers
echo "3. Stimulus Controllers:\n";
$attrs = Attributes::create()
    ->stimulus()->setController('dropdown')
    ->stimulus()->addController('tooltip')
    ->stimulus()->set('action', 'click->dropdown#toggle mouseover->tooltip#show')
    ->stimulus()->set('dropdown-open-class-value', 'active');

echo '<div' . $attrs->render() . '>Dropdown</div>' . "\n\n";

// Combined helpers
echo "4. Combined Example (Accessible Modal):\n";
$attrs = Attributes::create()
    ->set('id', 'modal-1')
    ->set('class', 'modal')
    ->aria()->set('modal', true)
    ->aria()->set('labelledby', 'modal-title')
    ->aria()->set('describedby', 'modal-description')
    ->set('tabindex', '-1')
    ->stimulus()->setController('modal')
    ->stimulus()->set('action', 'keydown.esc->modal#close click@window->modal#closeOnOutside')
    ->data()->set('backdrop', 'static');

echo '<div' . $attrs->render() . '>' . "\n";
echo "  <h2 id=\"modal-title\">Title</h2>\n";
echo "  <p id=\"modal-description\">Description</p>\n";
echo "</div>\n";
