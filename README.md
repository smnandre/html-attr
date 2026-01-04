<div align="center">
<h1><img src="./html-attr.png" width="100%" alt /></h1>

---

[![PHP Version](https://img.shields.io/badge/%C2%A0php-%3E%3D%208.2-777BB4.svg?logo=php&logoColor=white)](https://github.com/smnandre/ux-html/)
[![CI](https://github.com/smnandre/ux-html/actions/workflows/CI.yaml/badge.svg)](https://github.com/smnandre/ux-html/actions)
[![Release](https://img.shields.io/github/v/release/smnandre/ux-html)](https://github.com/smnandre/ux-html/releases)
[![License](https://img.shields.io/github/license/smnandre/ux-html?color=cc67ff)](https://github.com/smnandre/ux-html/blob/main/LICENSE)
[![Codecov](https://codecov.io/gh/smnandre/ux-html/graph/badge.svg?token=RC8Z6F4SPC)](https://codecov.io/gh/smnandre/ux-html)

</div>


> [!IMPORTANT] 
> This library is under active development. Its API, features, and documentation **will change**.

## Why Symfony UX HTML?

### The Problem

Building HTML attributes programmatically in PHP is tedious and error-prone:

```php
// Traditional approach
$classes = ['btn', 'btn-primary'];
if ($isDisabled) {
    $classes[] = 'disabled';
}
$classAttr = htmlspecialchars(implode(' ', $classes));

$attrs = [];
$attrs[] = 'class="' . $classAttr . '"';
$attrs[] = 'id="my-button"';
if ($isDisabled) {
    $attrs[] = 'disabled';
}
$attrs[] = 'aria-label="' . htmlspecialchars($label) . '"';

echo '<button ' . implode(' ', $attrs) . '>Click</button>';
```

### The Solution

**Symfony UX HTML** provides a fluent, type-safe, and secure API:

```php
use Symfony\UX\Html\Attribute\Attributes;

$attrs = Attributes::create()
    ->enableMagicMethods()
    ->id('my-button')
    ->class('btn btn-primary')
    ->toggle('disabled', $isDisabled)
    ->ariaLabel($label);

echo "<button{$attrs->render()}>Click</button>";
```

### Key Benefits

| Feature | Traditional | UX HTML |
|---------|-------------|---------|
| **Safety** | Manual `htmlspecialchars()` | Auto-escaped ✅ |
| **Immutability** | Mutable arrays | Immutable objects ✅ |
| **Readability** | String concatenation | Fluent API ✅ |
| **Type Safety** | Strings only | Typed methods ✅ |
| **Framework Integration** | Manual | Twig/Stimulus helpers ✅ |

### Perfect For

✅ Symfony/Twig applications  
✅ Component libraries (buttons, forms, modals)  
✅ Stimulus.js integration  
✅ Building accessible HTML (ARIA helpers)  
✅ Teams valuing code quality and DX  

### When NOT to Use

❌ Simple static HTML (overkill)  
❌ Performance-critical hot paths with millions of attributes  
❌ Non-PHP projects  

HTML Attributes is a fluent, immutable API for building and rendering HTML attribute strings in PHP. It was designed with performance, security, and developer experience in mind. Out of the box, it supports:

- **Immutable Operations:** Every modification returns a new instance.
- **Fluent Builder API:** Chain methods like `set()`, `add()`, `remove()`, and `toggle()`.
- **Magic Methods:** Enable natural method calls (e.g. `->ariaLabel('Close')` or `->disabled()`).
- **Namespaced Helpers:** Dedicated helpers for ARIA, Stimulus, and generic data attributes.
- **Secure Rendering:** All output is properly escaped.
- **High Performance:** Optimized for the most common attribute operations.

## Installation

```bash
composer require symfony/ux-html-attributes
```

## Basic Usage


The library provides a single entry point to build an attribute collection and render it as a string:

### Core API

```php
use Symfony\UX\Html\Attribute\Attributes;

$attributes = Attributes::create()
    ->set('id', 'my-id')
    ->add('class', 'btn')
    ->add('class', 'btn-primary')
    ->toggle('disabled', true)
    ->remove('hidden');
```

### DX-oriented API

```php
$attr = Attributes::create()
    ->enableMagicMethods()
    ->href('/smnandre')                  // Named methods
    ->class('btn btn-sm btn-red')        // Set multiple classes
    ->rel('external me')                 // Join multiple values
    ->disabled(true)                     // Boolean attributes
    ->ariaLabel('Hello')                 // Aria namespaced helpers
    ->title('Ah < Bh');                  // String escaping

echo $attr->render();                    // Safe HTML rendering
```

```html
<output
   href="/smnandre" class="btn btn-sm btn-red"
   rel="external me" disabled aria-label="Hello" title="Ah &lt; Bh" />
```

### Twig Extension

Use the Twig helper to fluently compose attributes inside your templates:

```twig
{# templates/components/button.html.twig #}
{% set attrs = attributes()
    .class('btn btn-primary')
    .ariaLabel('Submit form')
    .disabled(not isEnabled)
%}

<button{{ attrs }}>Submit</button>
```

## Features

### Core API

#### Immutable

Each method returns a new instance.

#### Basic Methods:

* **set(string $name, string|bool|null $value): self**  \
  Create or replace an attribute. Use `true` for boolean attributes and `false` or `null` to remove them. Join arrays with spaces before passing.
* **add(string $name, string|bool|null $value): self**  \
  Append to an existing attribute. When both values are strings they are concatenated with a space.
* **remove(string $name): self**  \
  Remove an attribute from the collection.
* **toggle(string $name, bool $condition): self**  \
  Add the attribute when `$condition` is `true`, otherwise remove it.
* **get(string $name): string|bool|null**  \
  Fetch the raw value of an attribute.
* **all(): array**  \
  Return all attributes as an associative array.
* **render(): string**  \
  Render the attribute string with proper escaping.

#### Magic Methods:

Calls such as `->disabled()`, `->ariaLabel('Close')`, or `->foo('bar')` are automatically converted to attribute names
in kebab-case and handled by the core API. 

### Namespaced Helpers

#### ARIA Attributes

Use the dedicated helper to set ARIA attributes:

```php
$attributes->aria()->set('label', 'Close');
// Sets "aria-label" to "Close"
```

#### Data Attributes

Use the generic data helper to manage custom `data-*` attributes:

```php
$attributes->data()->set('foo', 'bar');
// Sets "data-foo" to "bar"
```

#### Stimulus Attributes

Use the Stimulus helper to manage `data-*` attributes and controllers:

```php
$attributes = Attributes::create()
    ->stimulus()->setController('dropdown')
    ->stimulus()->addController('modal')
    ->stimulus()->set('action', 'click->example#toggle');

echo $attributes->render();
// data-controller="dropdown modal" data-action="click->example#toggle"
```

## Advanced Usage

### Boolean and Array Values

Boolean attributes are enabled by passing `true` and removed when `false` or
`null` is used:

```php
$attributes->disabled();       // Adds "disabled"
$attributes->hidden(false);    // Removes "hidden"
$attributes->hidden(true);     // Adds "hidden"
```

When working with arrays of values (e.g. classes) join them with spaces before
calling `set()` or `add()`:

```php
$classes = ['btn', 'btn-primary'];
$attributes->set('class', implode(' ', $classes));
```

```php
echo $attributes->render();
```

### Magic Methods

$attributes = Attributes::create()->enableMagicMethods();
$attributes->ariaLabel('Accessible Label'); // Sets aria-label="Accessible Label"
$attributes->foo('bar');                    // Sets foo="bar"
```

> [!IMPORTANT]
> The magic methods are NOT enabled by default. Call `enableMagicMethods()` on the factory or an instance to enable them.

### Combining Attributes

```php
$attributes = Attributes::create()
    ->set('id', 'example')
    ->aria()->set('expanded', true)
    ->stimulus()->addController('dropdown');

echo $attributes->render();
// Output might be: id="example" aria-expanded="true" data-controller="dropdown"
```

### Stimulus Helpers

```php
$attributes->stimulus()->setController('modal');
$attributes->stimulus()->addController('dropdown');
$attributes->stimulus()->set('action', 'click->dropdown#toggle');
```

### Future Features

Additional merging strategies and extensions are planned for future releases.

### Benchmarks

This library performs minimal allocations and defers escaping until render time.
Typical attribute manipulations take microseconds, making it suitable for high
performance applications.


## Configuration

Install via Composer and enable the bundle in Symfony:

```bash
composer require symfony/ux-html-attributes
```

```php
// config/bundles.php
return [
    Symfony\UX\Html\HtmlBundle::class => ['all' => true],
];
```

Use the `attributes()` helper in Twig to fluently build attribute sets:

```twig
{% set attrs = attributes().class('btn')->ariaLabel('Close') %}
<button{{ attrs }}>Close</button>
```

### Magic Method Setup

Enable the DX-oriented magic methods when creating an attribute set:

```php
use Symfony\UX\Html\Attribute\Attributes;

$attrs = Attributes::create()->enableMagicMethods();
```

## Documentation

Comprehensive documentation is available in the `docs/` directory:

- **[Installation Guide](docs/installation.rst)** - Getting started with the library
- **[Configuration](docs/configuration.rst)** - Configuring the bundle
- **[Basic Usage](docs/usage.rst)** - Core concepts and examples
- **[API Reference](docs/api-reference.rst)** - Complete API documentation
- **[Magic Methods](docs/magic-methods.rst)** - DX-oriented API
- **[Namespaced Helpers](docs/namespaced-helpers.rst)** - ARIA, Data, and Stimulus helpers
- **[Twig Integration](docs/twig.rst)** - Using in templates
- **[Security](docs/security.rst)** - XSS prevention and escaping

To build the HTML documentation locally:

```bash
# Install pandoc first (e.g., apt-get install pandoc)
make html
# Open docs/_build/html/index.html in your browser
```

## Testing

See [TESTING.md](_todo/TESTING.md) for details on running the test suite and collecting coverage.

## Credits

### Contributors
This library is developed by the Symfony UX team and community contributors.

### Sponsor
Support Symfony UX development by sponsoring the project at <https://github.com/symfony/ux>.

## License

This library is released under the [MIT license](LICENSE).
