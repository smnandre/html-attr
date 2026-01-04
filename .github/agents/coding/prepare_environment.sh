#!/bin/bash

# GitHub Copilot Agent Environment Preparation Script
# This script prepares the environment for the coding agent by installing
# necessary tools and dependencies for the ux-html PHP project.

set -e

echo "🚀 Preparing environment for GitHub Copilot coding agent..."

# Check PHP version
echo "📦 Checking PHP version..."
if command -v php &> /dev/null; then
    PHP_VERSION=$(php -r "echo PHP_VERSION;")
    echo "✓ PHP $PHP_VERSION is installed"
    
    # Verify PHP version is at least 8.2
    REQUIRED_VERSION="8.2"
    if php -r "exit(version_compare(PHP_VERSION, '$REQUIRED_VERSION', '<') ? 1 : 0);"; then
        echo "✓ PHP version meets requirement (>= $REQUIRED_VERSION)"
    else
        echo "⚠️  Warning: PHP version should be >= $REQUIRED_VERSION"
    fi
else
    echo "❌ PHP is not installed"
    exit 1
fi

# Check Composer
echo "📦 Checking Composer..."
if command -v composer &> /dev/null; then
    COMPOSER_VERSION=$(composer --version --no-ansi | head -n 1)
    echo "✓ $COMPOSER_VERSION is installed"
else
    echo "❌ Composer is not installed"
    exit 1
fi

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
if [ -f "composer.json" ]; then
    composer install --prefer-dist --no-progress --no-interaction
    echo "✓ Composer dependencies installed"
else
    echo "❌ composer.json not found"
    exit 1
fi

# Check for php-cs-fixer
echo "📦 Checking php-cs-fixer..."
if [ -f "vendor/bin/php-cs-fixer" ] || command -v php-cs-fixer &> /dev/null; then
    echo "✓ php-cs-fixer is available"
else
    echo "⚠️  php-cs-fixer not found (used for code style checking)"
fi

# Check for phpstan
echo "📦 Checking PHPStan..."
if [ -f "vendor/bin/phpstan" ] || command -v phpstan &> /dev/null; then
    echo "✓ PHPStan is available"
else
    echo "⚠️  PHPStan not found (used for static analysis)"
fi

# Check for phpunit
echo "📦 Checking PHPUnit..."
if [ -f "vendor/bin/phpunit" ]; then
    echo "✓ PHPUnit is available"
else
    echo "⚠️  PHPUnit not found (used for testing)"
fi

# Check for pandoc (optional, for documentation)
echo "📦 Checking pandoc (optional)..."
if command -v pandoc &> /dev/null; then
    PANDOC_VERSION=$(pandoc --version | head -n 1)
    echo "✓ $PANDOC_VERSION is installed"
else
    echo "ℹ️  pandoc not installed (optional - used for building HTML documentation)"
fi

echo ""
echo "✅ Environment preparation complete!"
echo ""
echo "Available commands:"
echo "  - composer test          # Run PHPUnit tests"
echo "  - composer phpstan       # Run static analysis"
echo "  - php-cs-fixer check     # Check code style"
echo "  - make html              # Build HTML documentation (requires pandoc)"
echo ""
