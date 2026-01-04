Installation
============

Requirements
------------

- PHP 8.2 or higher
- Symfony 7.2 or higher (when using with Symfony)

Installing with Composer
-------------------------

Install the package using Composer:

.. code-block:: bash

    composer require symfony/ux-html-attributes

Symfony Integration
-------------------

If you're using Symfony Flex, the bundle will be automatically registered. 
Otherwise, register it manually in your ``config/bundles.php``:

.. code-block:: php

    // config/bundles.php
    return [
        // ...
        Symfony\UX\Html\HtmlBundle::class => ['all' => true],
    ];

The bundle will automatically register the Twig extension and make the 
``attributes()`` helper available in your templates.

Standalone Usage
----------------

The library can also be used outside of Symfony:

.. code-block:: php

    <?php
    
    require_once __DIR__ . '/vendor/autoload.php';
    
    use Symfony\UX\Html\Attribute\Attributes;
    
    $attributes = Attributes::create()
        ->set('id', 'my-element')
        ->add('class', 'btn btn-primary');
    
    echo $attributes->render();
    // Output: id="my-element" class="btn btn-primary"

Verifying Installation
----------------------

To verify that the bundle is correctly installed and working:

1. **In Symfony**: Create a Twig template and use the ``attributes()`` helper:

   .. code-block:: twig

       {# templates/test.html.twig #}
       {% set attrs = attributes().class('test').id('example') %}
       <div{{ attrs }}>Test</div>

2. **Standalone**: Run a simple PHP script:

   .. code-block:: php

       <?php
       use Symfony\UX\Html\Attribute\Attributes;
       
       $attrs = Attributes::create()->set('class', 'test');
       echo $attrs->render(); // Should output: class="test"

Next Steps
----------

- Read the :doc:`configuration` guide to learn about available options
- Check out :doc:`usage` for basic usage examples
- Explore :doc:`magic-methods` for the DX-oriented API
