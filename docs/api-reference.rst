API Reference
=============

This reference documents all public methods of the HTML Attributes library.

Attributes Class
----------------

The ``Attributes`` class is the main entry point for creating and manipulating 
HTML attributes.

Factory Method
~~~~~~~~~~~~~~

.. code-block:: php

    public static function create(
        array $attributes = [],
        ?AttributeRendererInterface $renderer = null,
        bool $magicMethodsEnabled = false
    ): self

Creates a new ``Attributes`` instance.

**Parameters:**

- ``$attributes`` (array): Initial attributes as key-value pairs
- ``$renderer`` (AttributeRendererInterface|null): Custom renderer for attribute output
- ``$magicMethodsEnabled`` (bool): Enable magic methods (default: false)

**Returns:** ``Attributes`` instance

**Example:**

.. code-block:: php

    $attrs = Attributes::create();
    $attrs = Attributes::create(['id' => 'example']);
    $attrs = Attributes::create([], null, true); // With magic methods

Core Methods
~~~~~~~~~~~~

set()
^^^^^

.. code-block:: php

    public function set(string $name, string|bool|null $value): self

Sets an attribute value, replacing any existing value.

**Parameters:**

- ``$name`` (string): The attribute name
- ``$value`` (string|bool|null): The value. Use ``true`` for boolean attributes, 
  ``false``/``null`` to remove

**Returns:** New ``Attributes`` instance

**Example:**

.. code-block:: php

    $attrs = $attrs->set('id', 'my-id');
    $attrs = $attrs->set('disabled', true);
    $attrs = $attrs->set('hidden', false); // Removes hidden

add()
^^^^^

.. code-block:: php

    public function add(string $name, string|bool|null $value): self

Adds to an existing attribute value (concatenates with space).

**Parameters:**

- ``$name`` (string): The attribute name
- ``$value`` (string|bool|null): The value to add

**Returns:** New ``Attributes`` instance

**Example:**

.. code-block:: php

    $attrs = $attrs->set('class', 'btn');
    $attrs = $attrs->add('class', 'btn-primary'); // class="btn btn-primary"

remove()
^^^^^^^^

.. code-block:: php

    public function remove(string $name): self

Removes an attribute.

**Parameters:**

- ``$name`` (string): The attribute name to remove

**Returns:** New ``Attributes`` instance

**Example:**

.. code-block:: php

    $attrs = $attrs->remove('disabled');

toggle()
^^^^^^^^

.. code-block:: php

    public function toggle(string $name, bool $condition): self

Conditionally adds or removes an attribute.

**Parameters:**

- ``$name`` (string): The attribute name
- ``$condition`` (bool): Add if true, remove if false

**Returns:** New ``Attributes`` instance

**Example:**

.. code-block:: php

    $attrs = $attrs->toggle('disabled', $isDisabled);
    $attrs = $attrs->toggle('hidden', $shouldHide);

get()
^^^^^

.. code-block:: php

    public function get(string $name): string|bool|null

Gets the value of an attribute.

**Parameters:**

- ``$name`` (string): The attribute name

**Returns:** The attribute value, or ``null`` if not set

**Example:**

.. code-block:: php

    $id = $attrs->get('id');        // Returns string or null
    $disabled = $attrs->get('disabled'); // Returns true/false/null

all()
^^^^^

.. code-block:: php

    public function all(): array

Gets all attributes as an associative array.

**Returns:** Array of attribute name-value pairs

**Example:**

.. code-block:: php

    $allAttrs = $attrs->all();
    // ['id' => 'example', 'class' => 'btn', 'disabled' => true]

render()
^^^^^^^^

.. code-block:: php

    public function render(): string

Renders the attributes as an HTML string with proper escaping.

**Returns:** HTML attribute string

**Example:**

.. code-block:: php

    echo $attrs->render();
    // Output: id="example" class="btn" disabled

enableMagicMethods()
^^^^^^^^^^^^^^^^^^^^

.. code-block:: php

    public function enableMagicMethods(): self

Enables magic method calls for attribute manipulation.

**Returns:** New ``Attributes`` instance with magic methods enabled

**Example:**

.. code-block:: php

    $attrs = $attrs->enableMagicMethods();
    $attrs->ariaLabel('Close'); // Sets aria-label="Close"

Namespaced Helper Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~

aria()
^^^^^^

.. code-block:: php

    public function aria(): AriaHelper

Returns a helper for managing ARIA attributes.

**Returns:** ``AriaHelper`` instance

**Example:**

.. code-block:: php

    $attrs->aria()->set('label', 'Close');
    // Sets aria-label="Close"

data()
^^^^^^

.. code-block:: php

    public function data(): DataHelper

Returns a helper for managing data attributes.

**Returns:** ``DataHelper`` instance

**Example:**

.. code-block:: php

    $attrs->data()->set('id', '123');
    // Sets data-id="123"

stimulus()
^^^^^^^^^^

.. code-block:: php

    public function stimulus(): StimulusHelper

Returns a helper for managing Stimulus attributes.

**Returns:** ``StimulusHelper`` instance

**Example:**

.. code-block:: php

    $attrs->stimulus()->addController('modal');
    // Sets/adds to data-controller

AriaHelper Class
----------------

The ``AriaHelper`` provides methods for managing ARIA (Accessible Rich Internet 
Applications) attributes.

set()
~~~~~

.. code-block:: php

    public function set(string $name, string|bool|null $value): Attributes

Sets an ARIA attribute (automatically prefixes with ``aria-``).

**Parameters:**

- ``$name`` (string): ARIA attribute name (without ``aria-`` prefix)
- ``$value`` (string|bool|null): The value

**Returns:** Parent ``Attributes`` instance

**Example:**

.. code-block:: php

    $attrs->aria()->set('label', 'Close button');
    $attrs->aria()->set('expanded', true);
    $attrs->aria()->set('hidden', false);

add()
~~~~~

.. code-block:: php

    public function add(string $name, string|bool|null $value): Attributes

Adds to an ARIA attribute value.

**Parameters:**

- ``$name`` (string): ARIA attribute name (without ``aria-`` prefix)
- ``$value`` (string|bool|null): The value to add

**Returns:** Parent ``Attributes`` instance

remove()
~~~~~~~~

.. code-block:: php

    public function remove(string $name): Attributes

Removes an ARIA attribute.

**Parameters:**

- ``$name`` (string): ARIA attribute name (without ``aria-`` prefix)

**Returns:** Parent ``Attributes`` instance

DataHelper Class
----------------

The ``DataHelper`` provides methods for managing data attributes.

set()
~~~~~

.. code-block:: php

    public function set(string $name, string|bool|null $value): Attributes

Sets a data attribute (automatically prefixes with ``data-``).

**Parameters:**

- ``$name`` (string): Data attribute name (without ``data-`` prefix)
- ``$value`` (string|bool|null): The value

**Returns:** Parent ``Attributes`` instance

**Example:**

.. code-block:: php

    $attrs->data()->set('id', '123');
    $attrs->data()->set('user-name', 'john');

add()
~~~~~

.. code-block:: php

    public function add(string $name, string|bool|null $value): Attributes

Adds to a data attribute value.

remove()
~~~~~~~~

.. code-block:: php

    public function remove(string $name): Attributes

Removes a data attribute.

StimulusHelper Class
--------------------

The ``StimulusHelper`` provides methods for managing Stimulus framework attributes.

setController()
~~~~~~~~~~~~~~~

.. code-block:: php

    public function setController(string $name): Attributes

Sets the Stimulus controller (replaces existing controllers).

**Parameters:**

- ``$name`` (string): Controller name

**Returns:** Parent ``Attributes`` instance

**Example:**

.. code-block:: php

    $attrs->stimulus()->setController('modal');
    // Sets data-controller="modal"

addController()
~~~~~~~~~~~~~~~

.. code-block:: php

    public function addController(string $name): Attributes

Adds a Stimulus controller to existing controllers.

**Parameters:**

- ``$name`` (string): Controller name

**Returns:** Parent ``Attributes`` instance

**Example:**

.. code-block:: php

    $attrs->stimulus()->setController('modal');
    $attrs->stimulus()->addController('dropdown');
    // data-controller="modal dropdown"

set()
~~~~~

.. code-block:: php

    public function set(string $name, string|bool|null $value): Attributes

Sets a Stimulus data attribute.

**Parameters:**

- ``$name`` (string): Attribute name (without ``data-`` prefix)
- ``$value`` (string|bool|null): The value

**Returns:** Parent ``Attributes`` instance

**Example:**

.. code-block:: php

    $attrs->stimulus()->set('action', 'click->modal#open');

Magic Methods
-------------

When magic methods are enabled, you can call methods directly on the ``Attributes`` 
instance. Method names are converted to kebab-case attribute names.

.. code-block:: php

    $attrs = $attrs->enableMagicMethods();
    
    // These methods are dynamically handled:
    $attrs->id('my-id');           // Sets id="my-id"
    $attrs->className('btn');      // Sets class-name="btn"
    $attrs->ariaLabel('Close');    // Sets aria-label="Close"
    $attrs->dataId('123');         // Sets data-id="123"
    $attrs->disabled();            // Sets disabled (boolean)
    $attrs->disabled(true);        // Sets disabled (boolean)
    $attrs->disabled(false);       // Removes disabled

Constants
---------

The library does not define public constants.

Exceptions
----------

All exceptions thrown by the library extend ``\RuntimeException`` or 
``\InvalidArgumentException`` as appropriate.

See Also
--------

- :doc:`usage` - Basic usage examples
- :doc:`magic-methods` - Magic method details
- :doc:`namespaced-helpers` - Helper usage
- :doc:`twig` - Twig integration
