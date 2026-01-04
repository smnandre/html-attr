<?php

/**
 * Namespaced Helpers Example
 * 
 * This example demonstrates ARIA, Data, and Stimulus attribute helpers.
 */

require __DIR__.'/../vendor/autoload.php';

use Symfony\UX\Html\Attribute\Attributes;

// ARIA attributes
$button = Attributes::create()
    ->set('type', 'button')
    ->set('class', 'btn')
    ->aria()->set('label', 'Close dialog')
    ->aria()->set('expanded', 'false')
    ->aria()->set('controls', 'menu');

echo "Button with ARIA attributes:\n";
echo '<button' . $button . '>Close</button>' . "\n\n";
// Output: <button type="button" class="btn" aria-label="Close dialog" aria-expanded="false" aria-controls="menu">Close</button>

// Data attributes
$element = Attributes::create()
    ->set('class', 'product-item')
    ->data()->set('product-id', '12345')
    ->data()->set('price', '99.99')
    ->data()->set('category', 'electronics');

echo "Element with data attributes:\n";
echo '<div' . $element . '>Product</div>' . "\n\n";
// Output: <div class="product-item" data-product-id="12345" data-price="99.99" data-category="electronics">Product</div>

// Stimulus attributes
$dropdown = Attributes::create()
    ->set('class', 'dropdown')
    ->stimulus()->setController('dropdown')
    ->stimulus()->addController('tooltip')
    ->stimulus()->set('action', 'click->dropdown#toggle')
    ->stimulus()->set('target', 'dropdown.menu');

echo "Dropdown with Stimulus attributes:\n";
echo '<div' . $dropdown . '>' . "\n";
echo '  <button type="button">Menu</button>' . "\n";
echo '  <ul>' . "\n";
echo '    <li>Item 1</li>' . "\n";
echo '    <li>Item 2</li>' . "\n";
echo '  </ul>' . "\n";
echo '</div>' . "\n\n";
// Output: data-controller="dropdown tooltip" data-action="click->dropdown#toggle" data-dropdown-target="dropdown.menu"

// Combining all namespaced helpers
$modal = Attributes::create()
    ->set('id', 'confirmation-modal')
    ->set('class', 'modal')
    ->aria()->set('labelledby', 'modal-title')
    ->aria()->set('hidden', 'true')
    ->data()->set('backdrop', 'static')
    ->stimulus()->setController('modal')
    ->stimulus()->set('action', 'keydown.esc->modal#close');

echo "Modal with combined helpers:\n";
echo '<div' . $modal . '>Modal content</div>' . "\n";
// Output: <div id="confirmation-modal" class="modal" aria-labelledby="modal-title" aria-hidden="true" data-backdrop="static" data-controller="modal" data-action="keydown.esc->modal#close">Modal content</div>
