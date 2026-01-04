Namespaced Helpers
==================

Namespaced helpers provide specialized interfaces for managing groups of related 
attributes like ARIA attributes, data attributes, and Stimulus attributes.

ARIA Helper
-----------

The ARIA helper provides a clean interface for managing ARIA (Accessible Rich 
Internet Applications) attributes.

Accessing the ARIA Helper
~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    use Symfony\UX\Html\Attribute\Attributes;
    
    $attrs = Attributes::create();
    $ariaHelper = $attrs->aria();

Basic Usage
~~~~~~~~~~~

.. code-block:: php

    $attrs = Attributes::create()
        ->aria()->set('label', 'Close button')
        ->aria()->set('expanded', true)
        ->aria()->set('hidden', false);
    
    echo $attrs->render();
    // Output: aria-label="Close button" aria-expanded="true"

The ``aria-`` prefix is automatically added to all attribute names.

Common ARIA Attributes
~~~~~~~~~~~~~~~~~~~~~~

Labels and Descriptions
^^^^^^^^^^^^^^^^^^^^^^^

.. code-block:: php

    // Accessible name
    $attrs->aria()->set('label', 'Submit form');
    
    // Reference to labeling element
    $attrs->aria()->set('labelledby', 'form-title');
    
    // Reference to description
    $attrs->aria()->set('describedby', 'help-text');

State Attributes
^^^^^^^^^^^^^^^^

.. code-block:: php

    // Expanded/collapsed state
    $attrs->aria()->set('expanded', true);
    
    // Hidden from accessibility tree
    $attrs->aria()->set('hidden', true);
    
    // Pressed state for toggle buttons
    $attrs->aria()->set('pressed', false);
    
    // Selected state
    $attrs->aria()->set('selected', true);
    
    // Checked state
    $attrs->aria()->set('checked', 'mixed');

Property Attributes
^^^^^^^^^^^^^^^^^^^

.. code-block:: php

    // Disabled state
    $attrs->aria()->set('disabled', true);
    
    // Read-only state
    $attrs->aria()->set('readonly', true);
    
    // Required field
    $attrs->aria()->set('required', true);
    
    // Invalid state
    $attrs->aria()->set('invalid', true);

Live Region Attributes
^^^^^^^^^^^^^^^^^^^^^^

.. code-block:: php

    // Live region politeness
    $attrs->aria()->set('live', 'polite');     // or 'assertive', 'off'
    
    // Atomic updates
    $attrs->aria()->set('atomic', true);
    
    // Relevant updates
    $attrs->aria()->set('relevant', 'additions text');

Widget Attributes
^^^^^^^^^^^^^^^^^

.. code-block:: php

    // Controls relationship
    $attrs->aria()->set('controls', 'panel-1');
    
    // Owns relationship
    $attrs->aria()->set('owns', 'child-1 child-2');
    
    // Active descendant
    $attrs->aria()->set('activedescendant', 'option-3');
    
    // Autocomplete
    $attrs->aria()->set('autocomplete', 'list');

Role Attributes
^^^^^^^^^^^^^^^

.. code-block:: php

    // Current state
    $attrs->aria()->set('current', 'page');  // or 'step', 'location', 'date', 'time'
    
    // Has popup
    $attrs->aria()->set('haspopup', 'menu');  // or 'dialog', 'listbox', 'tree', 'grid'

Practical ARIA Examples
~~~~~~~~~~~~~~~~~~~~~~~~

Accessible Button
^^^^^^^^^^^^^^^^^

.. code-block:: php

    $attrs = Attributes::create()
        ->set('type', 'button')
        ->set('class', 'btn-close')
        ->aria()->set('label', 'Close dialog');
    
    echo '<button' . $attrs->render() . '>×</button>';

Expandable Panel
^^^^^^^^^^^^^^^^

.. code-block:: php

    $isExpanded = false;
    
    $buttonAttrs = Attributes::create()
        ->set('type', 'button')
        ->aria()->set('expanded', $isExpanded)
        ->aria()->set('controls', 'panel-content');
    
    $panelAttrs = Attributes::create()
        ->set('id', 'panel-content')
        ->toggle('hidden', !$isExpanded);

Form Input with Validation
^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. code-block:: php

    $hasError = true;
    
    $attrs = Attributes::create()
        ->set('type', 'text')
        ->set('name', 'email')
        ->aria()->set('required', true)
        ->aria()->set('invalid', $hasError)
        ->aria()->set('describedby', 'email-error');

Data Helper
-----------

The data helper manages generic ``data-*`` attributes.

Accessing the Data Helper
~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    $attrs = Attributes::create();
    $dataHelper = $attrs->data();

Basic Usage
~~~~~~~~~~~

.. code-block:: php

    $attrs = Attributes::create()
        ->data()->set('id', '123')
        ->data()->set('user-name', 'john')
        ->data()->set('product-id', '456');
    
    echo $attrs->render();
    // Output: data-id="123" data-user-name="john" data-product-id="456"

Common Data Attribute Patterns
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Storing IDs and References
^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. code-block:: php

    $attrs->data()->set('id', '123');
    $attrs->data()->set('parent-id', '456');
    $attrs->data()->set('user-id', '789');
    $attrs->data()->set('post-id', '101');

Configuration Values
^^^^^^^^^^^^^^^^^^^^

.. code-block:: php

    $attrs->data()->set('timeout', '5000');
    $attrs->data()->set('max-items', '10');
    $attrs->data()->set('enable-animation', 'true');

API Endpoints
^^^^^^^^^^^^^

.. code-block:: php

    $attrs->data()->set('url', '/api/users');
    $attrs->data()->set('method', 'POST');
    $attrs->data()->set('endpoint', '/api/comments');

State Information
^^^^^^^^^^^^^^^^^

.. code-block:: php

    $attrs->data()->set('state', 'active');
    $attrs->data()->set('status', 'pending');
    $attrs->data()->set('mode', 'edit');

Practical Data Examples
~~~~~~~~~~~~~~~~~~~~~~~~

API-Connected Element
^^^^^^^^^^^^^^^^^^^^^

.. code-block:: php

    $attrs = Attributes::create()
        ->set('class', 'user-card')
        ->data()->set('user-id', '123')
        ->data()->set('api-url', '/api/users/123')
        ->data()->set('fetch-on-load', 'true');

Interactive Widget
^^^^^^^^^^^^^^^^^^

.. code-block:: php

    $attrs = Attributes::create()
        ->set('class', 'carousel')
        ->data()->set('interval', '5000')
        ->data()->set('autoplay', 'true')
        ->data()->set('pause-on-hover', 'true');

Stimulus Helper
---------------

The Stimulus helper provides specialized methods for managing Stimulus framework 
attributes.

Accessing the Stimulus Helper
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    $attrs = Attributes::create();
    $stimulusHelper = $attrs->stimulus();

Controller Management
~~~~~~~~~~~~~~~~~~~~~

Setting Controllers
^^^^^^^^^^^^^^^^^^^

Use ``setController()`` to set a single controller (replaces existing):

.. code-block:: php

    $attrs = Attributes::create()
        ->stimulus()->setController('dropdown');
    
    echo $attrs->render();
    // Output: data-controller="dropdown"

Adding Controllers
^^^^^^^^^^^^^^^^^^

Use ``addController()`` to add controllers to existing ones:

.. code-block:: php

    $attrs = Attributes::create()
        ->stimulus()->setController('dropdown')
        ->stimulus()->addController('modal')
        ->stimulus()->addController('tooltip');
    
    echo $attrs->render();
    // Output: data-controller="dropdown modal tooltip"

Actions
~~~~~~~

Stimulus actions connect events to controller methods:

.. code-block:: php

    $attrs = Attributes::create()
        ->stimulus()->set('action', 'click->dropdown#toggle');
    
    // Multiple actions
    $attrs = Attributes::create()
        ->stimulus()->set('action', 'click->modal#open mouseenter->tooltip#show');

Action Format
^^^^^^^^^^^^^

Actions follow the format: ``event->controller#method``

.. code-block:: php

    // Click events
    $attrs->stimulus()->set('action', 'click->menu#toggle');
    
    // Multiple event types
    $attrs->stimulus()->set('action', 
        'mouseenter->tooltip#show mouseleave->tooltip#hide');
    
    // Form events
    $attrs->stimulus()->set('action', 'submit->form#validate');
    
    // Keyboard events
    $attrs->stimulus()->set('action', 'keydown->search#filter');

Targets
~~~~~~~

Stimulus targets identify elements within a controller:

.. code-block:: php

    // Single target
    $attrs = Attributes::create()
        ->stimulus()->set('target', 'dropdown.menu');
    
    // Multiple targets
    $attrs = Attributes::create()
        ->stimulus()->set('target', 'modal.content modal.backdrop');

Target Format
^^^^^^^^^^^^^

Targets follow the format: ``controller.name``

.. code-block:: php

    $attrs->stimulus()->set('target', 'dropdown.button');
    $attrs->stimulus()->set('target', 'modal.dialog');
    $attrs->stimulus()->set('target', 'form.input');

Values
~~~~~~

Stimulus values pass configuration to controllers:

.. code-block:: php

    // String value
    $attrs = Attributes::create()
        ->stimulus()->set('dropdown-open-value', 'true');
    
    // Numeric value
    $attrs = Attributes::create()
        ->stimulus()->set('modal-timeout-value', '5000');
    
    // Multiple values
    $attrs = Attributes::create()
        ->stimulus()->set('carousel-interval-value', '3000')
        ->stimulus()->set('carousel-autoplay-value', 'true');

Value Naming
^^^^^^^^^^^^

Values follow the format: ``controller-name-value``

.. code-block:: php

    $attrs->stimulus()->set('modal-backdrop-value', 'static');
    $attrs->stimulus()->set('tooltip-placement-value', 'top');
    $attrs->stimulus()->set('dropdown-offset-value', '10');

Classes
~~~~~~~

Stimulus classes define CSS classes for different states:

.. code-block:: php

    $attrs = Attributes::create()
        ->stimulus()->set('modal-open-class', 'is-open')
        ->stimulus()->set('modal-closing-class', 'is-closing');

Practical Stimulus Examples
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Dropdown Component
^^^^^^^^^^^^^^^^^^

.. code-block:: php

    // Dropdown button
    $buttonAttrs = Attributes::create()
        ->stimulus()->setController('dropdown')
        ->stimulus()->set('action', 'click->dropdown#toggle')
        ->stimulus()->set('target', 'dropdown.button');
    
    // Dropdown menu
    $menuAttrs = Attributes::create()
        ->stimulus()->set('target', 'dropdown.menu')
        ->set('hidden', true);

Modal Dialog
^^^^^^^^^^^^

.. code-block:: php

    // Open button
    $buttonAttrs = Attributes::create()
        ->stimulus()->set('action', 'click->modal#open')
        ->stimulus()->set('modal-target-value', '#user-modal');
    
    // Modal container
    $modalAttrs = Attributes::create()
        ->stimulus()->setController('modal')
        ->stimulus()->set('target', 'modal.dialog')
        ->stimulus()->set('modal-backdrop-value', 'static');
    
    // Close button
    $closeAttrs = Attributes::create()
        ->stimulus()->set('action', 'click->modal#close');

Form with Validation
^^^^^^^^^^^^^^^^^^^^

.. code-block:: php

    $formAttrs = Attributes::create()
        ->stimulus()->setController('form')
        ->stimulus()->set('action', 'submit->form#validate');
    
    $inputAttrs = Attributes::create()
        ->stimulus()->set('target', 'form.input')
        ->stimulus()->set('action', 'blur->form#validateField');

Real-time Search
^^^^^^^^^^^^^^^^

.. code-block:: php

    $attrs = Attributes::create()
        ->stimulus()->setController('search')
        ->stimulus()->set('search-url-value', '/api/search')
        ->stimulus()->set('search-min-length-value', '3')
        ->stimulus()->set('action', 'input->search#query');

Combining Helpers
-----------------

You can chain multiple helpers together:

.. code-block:: php

    $attrs = Attributes::create()
        ->set('id', 'submit-button')
        ->set('class', 'btn btn-primary')
        ->aria()->set('label', 'Submit form')
        ->aria()->set('expanded', false)
        ->data()->set('form-id', 'contact-form')
        ->stimulus()->setController('form')
        ->stimulus()->set('action', 'click->form#submit');

Complex Component Example
~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    $attrs = Attributes::create()
        ->set('id', 'user-dropdown')
        ->set('class', 'dropdown')
        ->aria()->set('haspopup', 'true')
        ->aria()->set('expanded', false)
        ->aria()->set('label', 'User menu')
        ->data()->set('user-id', '123')
        ->data()->set('role', 'admin')
        ->stimulus()->setController('dropdown')
        ->stimulus()->addController('tracking')
        ->stimulus()->set('action', 'click->dropdown#toggle click->tracking#event')
        ->stimulus()->set('dropdown-placement-value', 'bottom-end')
        ->stimulus()->set('tracking-category-value', 'user-menu');

Helper Method Chaining
-----------------------

All helper methods return the parent ``Attributes`` instance, allowing seamless 
chaining between helpers and core methods:

.. code-block:: php

    $attrs = Attributes::create()
        ->set('class', 'modal')              // Core method
        ->aria()->set('modal', true)          // ARIA helper
        ->set('role', 'dialog')              // Core method
        ->data()->set('backdrop', 'static')  // Data helper
        ->stimulus()->setController('modal') // Stimulus helper
        ->toggle('hidden', false);           // Core method

Best Practices
--------------

1. **Use Appropriate Helpers**: Use ARIA helper for accessibility, data helper 
   for generic data, and Stimulus helper for framework-specific attributes

2. **Consistent Naming**: Follow established naming conventions:
   
   - ARIA: Use standard ARIA attribute names without the ``aria-`` prefix
   - Data: Use kebab-case for multi-word names
   - Stimulus: Follow Stimulus naming conventions (controller#method format)

3. **Type Safety**: Pass appropriate types (booleans for boolean attributes, 
   strings for values)

4. **Validation**: ARIA attributes should use valid ARIA values (consult ARIA spec)

.. code-block:: php

    // ✓ Good
    $attrs->aria()->set('live', 'polite');  // Valid value
    
    // ✗ Bad
    $attrs->aria()->set('live', 'invalid'); // Not a valid ARIA live value

Next Steps
----------

- Review :doc:`twig` for using helpers in templates
- Check :doc:`security` for escaping and safety
- Explore :doc:`magic-methods` for the DX-oriented API
