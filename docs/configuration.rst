Configuration
=============

Basic Configuration
-------------------

The bundle works out of the box without any configuration. However, you can 
customize its behavior through various configuration options.

Bundle Configuration
--------------------

Currently, the bundle does not require specific configuration in 
``config/packages/html.yaml``. All configuration is done programmatically 
when creating attribute instances.

Magic Methods
-------------

Magic methods are **not** enabled by default. You can enable them when
creating an attribute instance:

.. code-block:: php

    use Symfony\UX\Html\Attribute\Attributes;

    // Enable magic methods for DX-oriented API
    $attributes = Attributes::create()->enableMagicMethods();

    // Now you can use magic methods
    $attributes->ariaLabel('Close');  // Sets aria-label="Close"
    $attributes->disabled();          // Adds disabled attribute

Next Steps
----------

- Learn about :doc:`usage` for basic attribute manipulation
- Check out :doc:`magic-methods` for the DX-oriented API
- Explore :doc:`namespaced-helpers` for ARIA and Stimulus helpers
