Basic Usage
===========

This guide covers the fundamental concepts and basic usage patterns of the 
HTML Attributes library.

Creating Attributes
-------------------

The main entry point is the ``Attributes`` class, which provides a factory 
method to create new attribute collections:

.. code-block:: php

    use Symfony\UX\Html\Attribute\Attributes;
    
    $attributes = Attributes::create();

Immutability
~~~~~~~~~~~~

All operations return a new instance, preserving immutability:

.. code-block:: php

    $attributes = Attributes::create();
    $withId = $attributes->set('id', 'my-id');
    
    // $attributes is unchanged
    // $withId is a new instance with the id attribute

Core Methods
------------

Setting Attributes
~~~~~~~~~~~~~~~~~~

Use ``set()`` to create or replace an attribute:

.. code-block:: php

    $attributes = Attributes::create()
        ->set('id', 'my-element')
        ->set('class', 'btn btn-primary')
        ->set('title', 'Click me');
    
    echo $attributes->render();
    // Output: id="my-element" class="btn btn-primary" title="Click me"

Adding to Attributes
~~~~~~~~~~~~~~~~~~~~

Use ``add()`` to append to existing attributes (with space separation):

.. code-block:: php

    $attributes = Attributes::create()
        ->set('class', 'btn')
        ->add('class', 'btn-primary')
        ->add('class', 'btn-lg');
    
    echo $attributes->render();
    // Output: class="btn btn-primary btn-lg"

Removing Attributes
~~~~~~~~~~~~~~~~~~~

Use ``remove()`` to delete an attribute:

.. code-block:: php

    $attributes = Attributes::create()
        ->set('id', 'example')
        ->set('class', 'btn')
        ->remove('id');
    
    echo $attributes->render();
    // Output: class="btn"

Toggling Attributes
~~~~~~~~~~~~~~~~~~~

Use ``toggle()`` to conditionally add or remove attributes:

.. code-block:: php

    $isDisabled = true;
    $isHidden = false;
    
    $attributes = Attributes::create()
        ->set('class', 'btn')
        ->toggle('disabled', $isDisabled)  // Adds disabled
        ->toggle('hidden', $isHidden);     // Removes hidden (if present)
    
    echo $attributes->render();
    // Output: class="btn" disabled

Getting Attribute Values
~~~~~~~~~~~~~~~~~~~~~~~~

Use ``get()`` to retrieve the value of an attribute:

.. code-block:: php

    $attributes = Attributes::create()
        ->set('id', 'my-element')
        ->set('class', 'btn');
    
    $id = $attributes->get('id');        // Returns: "my-element"
    $class = $attributes->get('class');  // Returns: "btn"
    $missing = $attributes->get('href'); // Returns: null

Getting All Attributes
~~~~~~~~~~~~~~~~~~~~~~

Use ``all()`` to get all attributes as an associative array:

.. code-block:: php

    $attributes = Attributes::create()
        ->set('id', 'example')
        ->set('class', 'btn');
    
    $all = $attributes->all();
    // Returns: ['id' => 'example', 'class' => 'btn']

Boolean Attributes
------------------

Boolean attributes are special HTML attributes that don't require a value 
(like ``disabled``, ``readonly``, ``required``).

Adding Boolean Attributes
~~~~~~~~~~~~~~~~~~~~~~~~~~

Pass ``true`` to set a boolean attribute:

.. code-block:: php

    $attributes = Attributes::create()
        ->set('disabled', true)
        ->set('readonly', true);
    
    echo $attributes->render();
    // Output: disabled readonly

Removing Boolean Attributes
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Pass ``false`` or ``null`` to remove a boolean attribute:

.. code-block:: php

    $attributes = Attributes::create()
        ->set('disabled', true)
        ->set('disabled', false);  // Removes disabled
    
    echo $attributes->render();
    // Output: (empty string)

Conditional Boolean Attributes
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    $isReadOnly = true;
    $isRequired = false;
    
    $attributes = Attributes::create()
        ->set('readonly', $isReadOnly)   // Adds readonly
        ->set('required', $isRequired);  // Doesn't add required
    
    echo $attributes->render();
    // Output: readonly

Working with Arrays
-------------------

When working with arrays of values (like multiple classes), join them with 
spaces before passing:

.. code-block:: php

    $classes = ['btn', 'btn-primary', 'btn-lg'];
    
    $attributes = Attributes::create()
        ->set('class', implode(' ', $classes));
    
    echo $attributes->render();
    // Output: class="btn btn-primary btn-lg"

Alternatively, add them one by one:

.. code-block:: php

    $attributes = Attributes::create();
    
    foreach (['btn', 'btn-primary', 'btn-lg'] as $class) {
        $attributes = $attributes->add('class', $class);
    }

Rendering
---------

Simple Rendering
~~~~~~~~~~~~~~~~

Use ``render()`` to get the final HTML attribute string:

.. code-block:: php

    $attributes = Attributes::create()
        ->set('id', 'button-1')
        ->set('class', 'btn');
    
    echo '<button ' . $attributes->render() . '>Click</button>';
    // Output: <button id="button-1" class="btn">Click</button>

Direct Output
~~~~~~~~~~~~~

The ``render()`` method returns a string that can be directly output:

.. code-block:: php

    $html = sprintf('<div %s>Content</div>', $attributes->render());

In Templates
~~~~~~~~~~~~

.. code-block:: php

    // In a PHP template
    <?php $attrs = Attributes::create()->set('class', 'container'); ?>
    <div <?= $attrs->render() ?>>
        Content
    </div>

Escaping and Security
---------------------

All attribute values are automatically escaped for safe HTML output:

.. code-block:: php

    $attributes = Attributes::create()
        ->set('title', 'This has "quotes" and <tags>')
        ->set('data-value', "Line 1\nLine 2");
    
    echo $attributes->render();
    // Output: title="This has &quot;quotes&quot; and &lt;tags&gt;" 
    //         data-value="Line 1&#10;Line 2"

.. seealso::
   See :doc:`security` for more information on XSS prevention and escaping.

Common Patterns
---------------

Building Dynamic Attributes
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    function buildButtonAttributes(bool $isPrimary, bool $isDisabled): Attributes
    {
        $attrs = Attributes::create()
            ->set('class', 'btn')
            ->set('type', 'button');
        
        if ($isPrimary) {
            $attrs = $attrs->add('class', 'btn-primary');
        } else {
            $attrs = $attrs->add('class', 'btn-secondary');
        }
        
        if ($isDisabled) {
            $attrs = $attrs->set('disabled', true);
        }
        
        return $attrs;
    }

Merging Attribute Sets
~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    // Base attributes
    $base = Attributes::create()
        ->set('class', 'form-control');
    
    // Specific attributes
    $specific = Attributes::create()
        ->set('id', 'username')
        ->set('name', 'username')
        ->set('required', true);
    
    // Combine by chaining methods
    $combined = Attributes::create()
        ->set('class', $base->get('class'))
        ->add('class', $specific->get('class') ?? '')
        ->set('id', $specific->get('id'))
        ->set('name', $specific->get('name'))
        ->set('required', $specific->get('required'));

Attribute Builders
~~~~~~~~~~~~~~~~~~

Create reusable builders for common patterns:

.. code-block:: php

    class ButtonAttributeBuilder
    {
        private Attributes $attributes;
        
        public function __construct()
        {
            $this->attributes = Attributes::create()
                ->set('class', 'btn')
                ->set('type', 'button');
        }
        
        public function primary(): self
        {
            $this->attributes = $this->attributes->add('class', 'btn-primary');
            return $this;
        }
        
        public function large(): self
        {
            $this->attributes = $this->attributes->add('class', 'btn-lg');
            return $this;
        }
        
        public function disabled(bool $disabled = true): self
        {
            $this->attributes = $this->attributes->set('disabled', $disabled);
            return $this;
        }
        
        public function build(): Attributes
        {
            return $this->attributes;
        }
    }
    
    // Usage
    $attrs = (new ButtonAttributeBuilder())
        ->primary()
        ->large()
        ->disabled()
        ->build();

Next Steps
----------

- Learn about :doc:`magic-methods` for a more convenient API
- Explore :doc:`namespaced-helpers` for ARIA, data, and Stimulus attributes
- Check out :doc:`twig` for template integration
