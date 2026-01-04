Documentation
=============

This directory hosts the reStructuredText sources for the HTML Attributes Bundle.

Building the HTML docs
----------------------

1. Install `pandoc <https://pandoc.org/installing.html>`_. For example:

   - Ubuntu/Debian: ``sudo apt-get install pandoc``
   - macOS: ``brew install pandoc``
   - Windows: ``choco install pandoc``

2. From the repository root, run::

       make html

   The generated output lives under ``docs/_build/html/``; open
   ``docs/_build/html/index.html`` in your browser to review it.

Cleaning build artifacts
------------------------

To remove the generated files, execute::

       make clean

This removes the ``docs/_build`` directory. Pandoc is not required for the
cleanup step.
