# CHANGELOG

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-01-XX

### Added

#### Core Features
- **Fluent Attribute API**: Immutable attribute building with `set()`, `add()`, `remove()`, `toggle()`
- **Magic Methods**: Optional DX-oriented API via `enableMagicMethods()`
  - Automatic camelCase to kebab-case conversion
  - Natural method chaining (e.g., `->ariaLabel()`, `->disabled()`)
- **Namespaced Helpers**:
  - ARIA attributes via `aria()->set()`
  - Data attributes via `data()->set()`
  - Stimulus integration via `stimulus()->setController()`, `stimulus()->addController()`
- **Extension System**: Pluggable attribute processing
  - `TailwindMergeExtension` for Tailwind CSS class deduplication
  - `BootstrapMergeExtension` for Bootstrap class handling
  - `StyleMergeExtension` for CSS property merging
  - `ExtensionManager` with priority support
- **Twig Integration**: `attributes()` helper function for template usage
- **Performance Metrics**: Optional `BasicPerformanceCollector` for timing data
- **Security**: Automatic HTML escaping for all attribute values

#### Developer Experience
- Comprehensive RST documentation (10+ guides)
- 5 runnable examples in `examples/` directory
- PHPStan level 8 compliance
- PHP-CS-Fixer with @PER-CS standard
- Full PHPUnit test coverage
- CI/CD with GitHub Actions (PHP 8.2, 8.3, 8.4)

#### Symfony Integration
- `HtmlBundle` for automatic registration
- Symfony Flex recipe support
- Compatible with Symfony 6.4+ and 7.x

### Changed
- **API Stabilization**: All public APIs frozen for semantic versioning
- **Package Name**:  Renamed to `symfony/ux-html` (from conceptual `ux-html-attributes`)
- **PHP Requirement**: Minimum PHP 8.2 required
- **Magic Methods**: Now opt-in via `enableMagicMethods()` (previously always enabled in prototype)

### Removed
- **Deprecated Classes**: Removed `MagicMethodAttributes` (use `enableMagicMethods()` instead)
- **Static Parser API**: `AttributesParser::parse()` now requires dependency injection via `ParserFactory`

### Fixed
- XSS prevention with comprehensive escaping tests
- Unicode attribute value handling
- Boolean attribute edge cases
- Extension priority ordering
- Cache LRU eviction accuracy

### Security
- All attribute values are escaped by default
- Protection against XSS via attribute injection
- Safe handling of user-provided input
- Tested against common attack vectors

### Documentation
- [Installation Guide](docs/installation.rst)
- [Configuration](docs/configuration.rst)
- [Basic Usage](docs/usage.rst)
- [API Reference](docs/api-reference.rst)
- [Magic Methods](docs/magic-methods.rst)
- [Namespaced Helpers](docs/namespaced-helpers.rst)
- [Extensions](docs/extensions.rst)
- [Twig Integration](docs/twig.rst)
- [Security Best Practices](docs/security.rst)
- [Performance Guide](docs/performance.rst)

## [0.1.0] - 2025-02-01

### Added
- Initial prototype implementation
- Basic attribute operations
- Proof of concept

---

[1.0.0]: https://github.com/smnandre/ux-html/releases/tag/v1.0.0
[0.1.0]: https://github.com/smnandre/ux-html/releases/tag/v0.1.0
