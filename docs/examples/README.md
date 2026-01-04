# Examples

This directory contains practical examples demonstrating the features of the `symfony/ux-html-attributes` package.

## Running the Examples

Make sure you have installed the dependencies:

```bash
composer install
```

Then run any example:

```bash
php examples/01-basic-usage.php
```

## Available Examples

### 1. Basic Usage (`01-basic-usage.php`)
Learn the fundamentals:
- Creating attributes
- Setting and adding values
- Boolean attributes
- Toggling attributes conditionally

### 2. Magic Methods (`02-magic-methods.php`)
Convenient DX-oriented API:
- Enabling magic methods
- CamelCase to kebab-case conversion
- Fluent method chaining
- Data attributes via magic methods

### 3. Namespaced Helpers (`03-namespaced-helpers.php`)
Specialized attribute helpers:
- ARIA attributes (`aria()->set()`)
- Data attributes (`data()->set()`)
- Stimulus controllers and actions
- Combining multiple helpers

### 4. Security (`05-security.php`)
XSS prevention and escaping:
- Automatic value escaping
- Attribute name sanitization
- JavaScript handler safety
- Unicode handling

## More Information

For complete documentation, see the main [README.md](../../README.md) file.
