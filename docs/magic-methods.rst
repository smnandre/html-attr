Magic Methods
=============

Magic methods provide a DX-oriented (Developer Experience) API for setting 
attributes using natural method calls instead of string-based attribute names.

.. important::
   Magic methods are **NOT** enabled by default. You must explicitly enable them 
   by calling ``enableMagicMethods()`` on your attribute instance.

Enabling Magic Methods
----------------------

To use magic methods, enable them when creating or on an existing instance:

.. code-block:: php

    use Symfony\UX\Html\Attribute\Attributes;
    
    // Enable on creation
    $attrs = Attributes::create()->enableMagicMethods();
    
    // Or enable on existing instance
    $attrs = Attributes::create();
    $attrs = $attrs->enableMagicMethods();

Basic Usage
-----------

Once enabled, you can call methods directly using attribute names:

.. code-block:: php

    $attrs = Attributes::create()->enableMagicMethods();
    
    // Simple attributes
    $attrs->id('my-element');
    $attrs->title('Click here');
    
    echo $attrs->render();
    // Output: id="my-element" title="Click here"

Method Name Conversion
----------------------

Method names are automatically converted to kebab-case attribute names:

CamelCase to Kebab-Case
~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    $attrs->className('btn');      // Sets class-name="btn"
    $attrs->dataId('123');         // Sets data-id="123"
    $attrs->ariaLabel('Close');    // Sets aria-label="Close"
    $attrs->dataUserId('456');     // Sets data-user-id="456"

Standard Names
~~~~~~~~~~~~~~

Single-word method names map directly:

.. code-block:: php

    $attrs->id('example');         // Sets id="example"
    $attrs->class('btn');          // Sets class="btn"
    $attrs->title('Title');        // Sets title="Title"
    $attrs->href('/path');         // Sets href="/path"
    $attrs->src('/image.jpg');     // Sets src="/image.jpg"

Boolean Attributes
------------------

Magic methods support boolean attributes naturally:

Without Arguments
~~~~~~~~~~~~~~~~~

Calling a magic method without arguments adds a boolean attribute:

.. code-block:: php

    $attrs->disabled();            // Adds disabled attribute
    $attrs->readonly();            // Adds readonly attribute
    $attrs->required();            // Adds required attribute
    
    echo $attrs->render();
    // Output: disabled readonly required

With Boolean Arguments
~~~~~~~~~~~~~~~~~~~~~~

Pass ``true`` or ``false`` explicitly:

.. code-block:: php

    $isDisabled = true;
    $isRequired = false;
    
    $attrs->disabled($isDisabled);   // Adds disabled
    $attrs->required($isRequired);   // Removes required (if present)

Common Boolean Attributes
~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    $attrs->disabled();
    $attrs->readonly();
    $attrs->required();
    $attrs->autofocus();
    $attrs->checked();
    $attrs->selected();
    $attrs->hidden();
    $attrs->multiple();
    $attrs->autoplay();
    $attrs->controls();
    $attrs->loop();
    $attrs->muted();

String Values
-------------

Pass string values as the first argument:

.. code-block:: php

    $attrs->id('submit-button');
    $attrs->name('username');
    $attrs->placeholder('Enter your name');
    $attrs->pattern('[A-Za-z]+');
    $attrs->title('This is a tooltip');

Multiple Values
~~~~~~~~~~~~~~~

For attributes that accept multiple values (like classes), join them:

.. code-block:: php

    $attrs->class('btn btn-primary btn-lg');
    $attrs->rel('nofollow noopener noreferrer');

.. note::
   Magic methods use ``set()`` internally, so they replace existing values. 
   To append to existing values, use the core API's ``add()`` method.

ARIA Attributes
---------------

Magic methods work seamlessly with ARIA attributes:

.. code-block:: php

    $attrs->ariaLabel('Close button');
    $attrs->ariaExpanded(true);
    $attrs->ariaHidden(false);
    $attrs->ariaDescribedBy('description-1');
    $attrs->ariaControls('panel-1');
    $attrs->ariaLive('polite');

Common ARIA Attributes
~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    $attrs->ariaLabel('Accessible name');
    $attrs->ariaLabelledBy('label-id');
    $attrs->ariaDescribedBy('desc-id');
    $attrs->ariaExpanded(true);
    $attrs->ariaHidden(true);
    $attrs->ariaPressed(false);
    $attrs->ariaSelected(false);
    $attrs->ariaChecked(true);
    $attrs->ariaDisabled(true);
    $attrs->ariaReadOnly(true);
    $attrs->ariaRequired(true);
    $attrs->ariaInvalid(false);

Data Attributes
---------------

Data attributes work naturally with magic methods:

.. code-block:: php

    $attrs->dataId('123');
    $attrs->dataUserId('456');
    $attrs->dataProductName('Widget');
    $attrs->dataActionTarget('modal.element');

Stimulus Attributes
~~~~~~~~~~~~~~~~~~~

For Stimulus controllers and actions:

.. code-block:: php

    $attrs->dataController('modal dropdown');
    $attrs->dataAction('click->modal#open');
    $attrs->dataModalOpenValue('true');

.. seealso::
   For more control over Stimulus attributes, use the dedicated 
   :doc:`namespaced-helpers` (``stimulus()`` helper).

Chaining
--------

Magic methods return the ``Attributes`` instance, enabling method chaining:

.. code-block:: php

    $attrs = Attributes::create()
        ->enableMagicMethods()
        ->id('submit-btn')
        ->class('btn btn-primary')
        ->type('submit')
        ->disabled(false)
        ->ariaLabel('Submit form')
        ->dataController('form');
    
    echo $attrs->render();

Practical Examples
------------------

Button with All Features
~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    $attrs = Attributes::create()
        ->enableMagicMethods()
        ->id('action-button')
        ->class('btn btn-lg btn-success')
        ->type('button')
        ->ariaLabel('Perform action')
        ->dataController('action')
        ->dataAction('click->action#execute');
    
    echo '<button' . $attrs->render() . '>Action</button>';

Form Input Field
~~~~~~~~~~~~~~~~

.. code-block:: php

    $attrs = Attributes::create()
        ->enableMagicMethods()
        ->id('email-input')
        ->name('email')
        ->type('email')
        ->class('form-control')
        ->placeholder('Enter your email')
        ->required()
        ->ariaDescribedBy('email-help')
        ->ariaInvalid(false);
    
    echo '<input' . $attrs->render() . '>';

Image with ARIA
~~~~~~~~~~~~~~~

.. code-block:: php

    $attrs = Attributes::create()
        ->enableMagicMethods()
        ->src('/images/logo.png')
        ->alt('Company logo')
        ->class('logo img-fluid')
        ->loading('lazy')
        ->ariaHidden(false);
    
    echo '<img' . $attrs->render() . '>';

Link with Security
~~~~~~~~~~~~~~~~~~

.. code-block:: php

    $attrs = Attributes::create()
        ->enableMagicMethods()
        ->href('https://example.com')
        ->target('_blank')
        ->rel('noopener noreferrer')
        ->class('external-link')
        ->ariaLabel('Opens in new window');
    
    echo '<a' . $attrs->render() . '>Visit Site</a>';

Conditional Attributes
~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    function buildInputAttrs(string $name, bool $isRequired, ?string $error): Attributes
    {
        $attrs = Attributes::create()
            ->enableMagicMethods()
            ->name($name)
            ->class('form-control')
            ->type('text');
        
        if ($isRequired) {
            $attrs = $attrs->required();
        }
        
        if ($error) {
            $attrs = $attrs
                ->class('form-control is-invalid')
                ->ariaInvalid(true)
                ->ariaDescribedBy($name . '-error');
        }
        
        return $attrs;
    }

Combining with Core API
-----------------------

You can mix magic methods with the core API:

.. code-block:: php

    $attrs = Attributes::create()
        ->enableMagicMethods()
        ->id('button-1')              // Magic method
        ->set('class', 'btn')         // Core API
        ->add('class', 'btn-primary') // Core API
        ->disabled()                  // Magic method
        ->toggle('hidden', false);    // Core API

Limitations
-----------

Magic Method Scope
~~~~~~~~~~~~~~~~~~

Magic methods only work on the main ``Attributes`` instance, not on helpers:

.. code-block:: php

    // ✓ Works
    $attrs->ariaLabel('Close');
    
    // ✓ Also works, but different approach
    $attrs->aria()->set('label', 'Close');
    
    // ✗ Does NOT work - helpers don't support magic methods
    // $attrs->aria()->label('Close');

Reserved Method Names
~~~~~~~~~~~~~~~~~~~~~

Magic methods cannot override existing public methods:

.. code-block:: php

    // These are real methods and cannot be overridden:
    $attrs->set('name', 'value');        // Core method
    $attrs->add('class', 'btn');         // Core method
    $attrs->remove('disabled');          // Core method
    $attrs->toggle('hidden', false);     // Core method
    $attrs->get('id');                   // Core method
    $attrs->all();                       // Core method
    $attrs->render();                    // Core method
    $attrs->aria();                      // Helper method
    $attrs->data();                      // Helper method
    $attrs->stimulus();                  // Helper method

Performance Considerations
--------------------------

Magic methods have a small performance overhead compared to the core API 
because they use PHP's ``__call()`` method for dynamic dispatch.

For high-performance scenarios where attributes are created in tight loops, 
consider using the core API directly:

.. code-block:: php

    // Slightly faster
    for ($i = 0; $i < 10000; $i++) {
        $attrs = Attributes::create()
            ->set('id', "item-$i")
            ->set('class', 'item');
    }
    
    // Slightly slower (but more readable)
    for ($i = 0; $i < 10000; $i++) {
        $attrs = Attributes::create()
            ->enableMagicMethods()
            ->id("item-$i")
            ->class('item');
    }

.. note::
   The performance difference is typically negligible for normal use cases. 
   Use magic methods for better developer experience unless profiling shows 
   they're a bottleneck.

Best Practices
--------------

1. **Enable Once**: Enable magic methods once at the start of your attribute chain
2. **Consistent Style**: Choose either magic methods or core API for consistency
3. **Document Usage**: Document when magic methods are expected in your codebase
4. **IDE Support**: Use type hints to maintain IDE autocomplete for core methods

.. code-block:: php

    /** @var Attributes $attrs */
    $attrs = Attributes::create()
        ->enableMagicMethods()
        ->id('example');

Next Steps
----------

- Explore :doc:`namespaced-helpers` for dedicated ARIA, data, and Stimulus helpers
- Check :doc:`twig` for using magic methods in templates
- Review :doc:`api-reference` for all available methods
