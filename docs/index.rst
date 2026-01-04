HTML Attributes Bundle
======================

The **HTML Attributes Bundle** provides a fluent, immutable API for building and 
rendering HTML attribute strings in PHP. It was designed with performance, security, 
and developer experience in mind.

.. image:: https://img.shields.io/badge/%C2%A0php-%3E%3D%208.2-777BB4.svg?logo=php&logoColor=white
   :target: https://github.com/smnandre/ux-html/
   :alt: PHP Version

.. image:: https://github.com/smnandre/ux-html/actions/workflows/CI.yaml/badge.svg
   :target: https://github.com/smnandre/ux-html/actions
   :alt: CI

.. image:: https://img.shields.io/github/v/release/smnandre/ux-html
   :target: https://github.com/smnandre/ux-html/releases
   :alt: Release

.. image:: https://img.shields.io/github/license/smnandre/ux-html?color=cc67ff
   :target: https://github.com/smnandre/ux-html/blob/main/LICENSE
   :alt: License

.. important::
   This library is under active development. Its API, features, and documentation 
   **will change**.

Features
--------

- **Immutable Operations:** Every modification returns a new instance
- **Fluent Builder API:** Chain methods like ``set()``, ``add()``, ``remove()``, and ``toggle()``
- **Magic Methods:** Enable natural method calls (e.g. ``->ariaLabel('Close')`` or ``->disabled()``)
- **Namespaced Helpers:** Dedicated helpers for ARIA, Stimulus, and generic data attributes
- **Secure Rendering:** All output is properly escaped
- **High Performance:** Optimized for the most common attribute operations

Installation
------------

.. code-block:: bash

    composer require symfony/ux-html-attributes

Documentation
-------------

.. toctree::
   :maxdepth: 2

   installation
   configuration
   usage
   api-reference
   magic-methods
   namespaced-helpers
   twig
   security

Indices and tables
------------------

* :ref:`genindex`
* :ref:`search`
