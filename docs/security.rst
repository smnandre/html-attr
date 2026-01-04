Security
========

The HTML Attributes library is designed with security as a top priority. All 
output is properly escaped to prevent XSS (Cross-Site Scripting) attacks and 
other security vulnerabilities.

Automatic Escaping
------------------

All attribute values are automatically escaped when rendered, protecting against 
XSS attacks without requiring manual intervention.

HTML Entity Encoding
~~~~~~~~~~~~~~~~~~~~~

Special characters are converted to HTML entities:

.. code-block:: php

    $attrs = Attributes::create()
        ->set('title', 'This has "quotes" and <tags>');
    
    echo $attrs->render();
    // Output: title="This has &quot;quotes&quot; and &lt;tags&gt;"

The following characters are escaped:

- ``<`` becomes ``&lt;``
- ``>`` becomes ``&gt;``
- ``"`` becomes ``&quot;``
- ``'`` becomes ``&#039;``
- ``&`` becomes ``&amp;``

Line Breaks and Special Characters
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Line breaks and other special characters are properly encoded:

.. code-block:: php

    $attrs = Attributes::create()
        ->set('data-value', "Line 1\nLine 2\tTabbed")
        ->set('data-unicode', 'Emoji: 😀');
    
    echo $attrs->render();
    // Output: data-value="Line 1&#10;Line 2&#9;Tabbed" data-unicode="Emoji: 😀"

XSS Prevention
--------------

User Input Protection
~~~~~~~~~~~~~~~~~~~~~

User-provided data is safe to use directly:

.. code-block:: php

    // Unsafe user input
    $userInput = $_POST['title'] ?? '<script>alert("XSS")</script>';
    
    // Safe - automatically escaped
    $attrs = Attributes::create()
        ->set('title', $userInput);
    
    echo $attrs->render();
    // Output: title="&lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;"

This prevents:

- Script injection: ``<script>`` tags
- Event handler injection: ``onclick="malicious()"``
- URL-based attacks: ``javascript:`` URLs (when used in href)
- Style injection: ``<style>`` tags

JavaScript Handler Safety
~~~~~~~~~~~~~~~~~~~~~~~~~~

Even inline JavaScript is escaped:

.. code-block:: php

    $malicious = 'alert("XSS")';
    
    $attrs = Attributes::create()
        ->set('onclick', $malicious);
    
    echo $attrs->render();
    // Output: onclick="alert(&quot;XSS&quot;)"

.. warning::
   While the library escapes inline JavaScript, using inline event handlers 
   is not recommended. Use Stimulus or other unobtrusive JavaScript approaches 
   instead.

Attribute Name Sanitization
----------------------------

The library validates attribute names to prevent injection attacks through 
attribute names themselves.

Valid Attribute Names
~~~~~~~~~~~~~~~~~~~~~

Attribute names must follow HTML conventions:

.. code-block:: php

    // ✓ Valid attribute names
    $attrs->set('id', 'value');
    $attrs->set('class', 'value');
    $attrs->set('data-custom', 'value');
    $attrs->set('aria-label', 'value');

Invalid Attribute Names
~~~~~~~~~~~~~~~~~~~~~~~

Attribute names with invalid characters are rejected:

.. code-block:: php

    // ✗ Invalid - will be rejected or sanitized
    $attrs->set('on<script>', 'value');        // Contains < >
    $attrs->set('attr name', 'value');         // Contains space
    $attrs->set('attr"name', 'value');         // Contains quote

Safe Attribute Patterns
-----------------------

URL Attributes
~~~~~~~~~~~~~~

URLs in href, src, and similar attributes are escaped:

.. code-block:: php

    $attrs = Attributes::create()
        ->set('href', 'https://example.com?foo=bar&baz=qux');
    
    echo $attrs->render();
    // Output: href="https://example.com?foo=bar&amp;baz=qux"

.. warning::
   The library escapes URL values but doesn't validate URL schemes. Avoid 
   using user input directly in URLs without validation:
   
   .. code-block:: php
   
       // ✗ Dangerous - user could provide javascript: URLs
       $attrs->set('href', $_GET['url']);
       
       // ✓ Better - validate URL scheme
       $url = $_GET['url'];
       if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
           $attrs->set('href', $url);
       }

Data Attributes
~~~~~~~~~~~~~~~

Data attributes are safe for storing user content:

.. code-block:: php

    $userContent = $_POST['description'];
    
    $attrs = Attributes::create()
        ->data()->set('description', $userContent);
    
    // Safe - escaped on render
    echo $attrs->render();

JSON in Data Attributes
^^^^^^^^^^^^^^^^^^^^^^^

When storing JSON in data attributes, ensure proper encoding:

.. code-block:: php

    // ✓ Safe - JSON encoding + escaping
    $data = ['user' => 'John', 'role' => 'admin'];
    $attrs = Attributes::create()
        ->data()->set('config', json_encode($data));
    
    echo $attrs->render();
    // Output: data-config="{&quot;user&quot;:&quot;John&quot;,&quot;role&quot;:&quot;admin&quot;}"

ARIA Attributes
~~~~~~~~~~~~~~~

ARIA attributes are escaped like regular attributes:

.. code-block:: php

    $userLabel = $_POST['label'];
    
    $attrs = Attributes::create()
        ->aria()->set('label', $userLabel);
    
    // Safe - escaped on render

Content Security Policy (CSP)
------------------------------

The library's escaping helps with CSP compliance:

Safe for Strict CSP
~~~~~~~~~~~~~~~~~~~

Since all attributes are escaped, the library doesn't introduce CSP violations:

.. code-block:: php

    // No inline scripts generated
    $attrs = Attributes::create()
        ->set('class', 'btn')
        ->data()->set('action', 'submit');
    
    // Output only contains safe attribute strings

Use with Stimulus
~~~~~~~~~~~~~~~~~

Combine with Stimulus for CSP-compliant JavaScript:

.. code-block:: php

    // ✓ CSP-compliant - no inline handlers
    $attrs = Attributes::create()
        ->stimulus()->setController('form')
        ->stimulus()->set('action', 'click->form#submit');
    
    // ✗ CSP violation - inline handler
    $attrs = Attributes::create()
        ->set('onclick', 'submitForm()');

Common Security Pitfalls
------------------------

Avoid Raw Output
~~~~~~~~~~~~~~~~

Never bypass the automatic escaping:

.. code-block:: php

    $attrs = Attributes::create()->set('title', 'Safe');
    
    // ✓ Safe - uses render() with escaping
    echo '<div ' . $attrs->render() . '>';
    
    // ✗ Dangerous - manual construction without escaping
    echo '<div title="' . $attrs->get('title') . '">';

Validate User Input
~~~~~~~~~~~~~~~~~~~

While escaping prevents XSS, still validate input for business logic:

.. code-block:: php

    $userId = $_GET['id'];
    
    // ✓ Good - validate before use
    if (ctype_digit($userId)) {
        $attrs->data()->set('user-id', $userId);
    }
    
    // ✗ Bad - no validation (escaping prevents XSS but allows invalid IDs)
    $attrs->data()->set('user-id', $userId);

URL Scheme Validation
~~~~~~~~~~~~~~~~~~~~~~

Validate URL schemes for href and src attributes:

.. code-block:: php

    function isAllowedUrl(string $url): bool
    {
        $allowed = ['http://', 'https://', 'mailto:', '/'];
        
        foreach ($allowed as $prefix) {
            if (str_starts_with($url, $prefix)) {
                return true;
            }
        }
        
        return false;
    }
    
    $url = $_GET['redirect'];
    
    if (isAllowedUrl($url)) {
        $attrs->set('href', $url);
    }

Trusted Content
---------------

When You Control the Content
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The library escapes everything, even content you trust:

.. code-block:: php

    // This is escaped even though you control it
    $attrs = Attributes::create()
        ->set('data-html', '<strong>Bold</strong>');
    
    echo $attrs->render();
    // Output: data-html="&lt;strong&gt;Bold&lt;/strong&gt;"

This is by design - consistency prevents mistakes.

If You Need Raw HTML
~~~~~~~~~~~~~~~~~~~~

The library is designed for attributes, not HTML content. For HTML content, 
use appropriate template functions:

.. code-block:: twig

    {# In Twig #}
    {% set attrs = attributes().set('class', 'content') %}
    
    {# Safe attributes #}
    <div{{ attrs }}>
        {# Content rendering - use appropriate filter #}
        {{ content|raw }}  {# Only if content is trusted #}
    </div>

Security Best Practices
-----------------------

1. **Trust the Escaping**: The library handles escaping automatically
2. **Validate Input**: Validate user input for business rules
3. **Check URL Schemes**: Validate URL schemes in href/src attributes
4. **Use Stimulus**: Avoid inline event handlers
5. **CSP Compliance**: Use the library with CSP for defense in depth
6. **Regular Updates**: Keep the library updated for security fixes

Secure Coding Examples
----------------------

User Profile Card
~~~~~~~~~~~~~~~~~

.. code-block:: php

    function buildUserCard(array $userData): Attributes
    {
        // Validate user ID
        $userId = filter_var($userData['id'], FILTER_VALIDATE_INT);
        if ($userId === false) {
            throw new \InvalidArgumentException('Invalid user ID');
        }
        
        // Sanitize name (escaping is automatic)
        $name = trim($userData['name']);
        
        // Validate URL
        $avatar = $userData['avatar'] ?? '/images/default-avatar.png';
        if (!str_starts_with($avatar, '/') && !filter_var($avatar, FILTER_VALIDATE_URL)) {
            $avatar = '/images/default-avatar.png';
        }
        
        return Attributes::create()
            ->set('class', 'user-card')
            ->data()->set('user-id', (string) $userId)
            ->data()->set('name', $name)
            ->data()->set('avatar', $avatar);
    }

Form Input with Validation
~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    function buildInput(string $name, ?string $value, ?string $error): Attributes
    {
        // Validate field name (only alphanumeric and underscore)
        if (!preg_match('/^[a-z_][a-z0-9_]*$/i', $name)) {
            throw new \InvalidArgumentException('Invalid field name');
        }
        
        $attrs = Attributes::create()
            ->set('type', 'text')
            ->set('name', $name)
            ->set('id', $name)
            ->set('class', 'form-control');
        
        // Value is escaped automatically
        if ($value !== null) {
            $attrs = $attrs->set('value', $value);
        }
        
        // Error message is escaped automatically
        if ($error !== null) {
            $attrs = $attrs
                ->add('class', 'is-invalid')
                ->aria()->set('invalid', true)
                ->aria()->set('describedby', $name . '_error');
        }
        
        return $attrs;
    }

Testing Security
----------------

Write tests to verify escaping behavior:

.. code-block:: php

    use PHPUnit\Framework\TestCase;
    use Symfony\UX\Html\Attribute\Attributes;
    
    class SecurityTest extends TestCase
    {
        public function testScriptTagsAreEscaped(): void
        {
            $attrs = Attributes::create()
                ->set('title', '<script>alert("XSS")</script>');
            
            $output = $attrs->render();
            
            $this->assertStringNotContainsString('<script>', $output);
            $this->assertStringContainsString('&lt;script&gt;', $output);
        }
        
        public function testQuotesAreEscaped(): void
        {
            $attrs = Attributes::create()
                ->set('title', 'He said "Hello"');
            
            $output = $attrs->render();
            
            $this->assertStringContainsString('&quot;', $output);
        }
        
        public function testUserInputIsSafe(): void
        {
            // Simulate malicious user input
            $malicious = '"><script>alert("XSS")</script><div class="';
            
            $attrs = Attributes::create()
                ->set('data-user-input', $malicious);
            
            $output = $attrs->render();
            
            // Should not create valid script tag
            $this->assertStringNotContainsString('<script>', $output);
        }
    }

Reporting Security Issues
--------------------------

If you discover a security vulnerability in the library, please report it 
responsibly:

1. **Do not** open a public issue
2. Email the maintainers directly
3. Include detailed information about the vulnerability
4. Allow time for a fix before public disclosure

Next Steps
----------

- Review :doc:`twig` for secure template usage
- Check :doc:`api-reference` for method details
- Explore :doc:`usage` for safe patterns
