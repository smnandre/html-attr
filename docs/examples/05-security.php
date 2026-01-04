<?php

/**
 * Security Example
 * 
 * This example demonstrates XSS prevention and proper escaping.
 */

require __DIR__.'/../vendor/autoload.php';

use Symfony\UX\Html\Attribute\Attributes;

// XSS prevention in attribute values
$maliciousValue = '<script>alert("XSS")</script>';
$attrs = Attributes::create()
    ->set('title', $maliciousValue)
    ->set('data-content', 'User input: ' . $maliciousValue);

echo "XSS prevention in values:\n";
echo '<div' . $attrs . '>Safe content</div>' . "\n\n";
// Output: <div title="&lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;" data-content="User input: &lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;">Safe content</div>

// XSS prevention in attribute names
$maliciousName = '"><script>alert(1)</script>';
$attrs2 = Attributes::create()
    ->set($maliciousName, 'value');

echo "XSS prevention in names:\n";
echo '<div' . $attrs2 . '>Safe content</div>' . "\n\n";
// Output: Attribute name is escaped

// JavaScript event handlers are properly escaped
$attrs3 = Attributes::create()
    ->set('onclick', 'alert("XSS")');

echo "JavaScript handlers are escaped:\n";
echo '<button' . $attrs3 . '>Click me</button>' . "\n\n";
// Output: <button onclick="alert(&quot;XSS&quot;)">Click me</button>

// Special characters are handled correctly
$attrs4 = Attributes::create()
    ->set('title', 'Quotes: " and \' and ampersand: &')
    ->set('data-value', 'Less than < and greater than >');

echo "Special characters:\n";
echo '<div' . $attrs4 . '>Content</div>' . "\n\n";
// Output: <div title="Quotes: &quot; and &#039; and ampersand: &amp;" data-value="Less than &lt; and greater than &gt;">Content</div>

// Unicode is preserved
$attrs5 = Attributes::create()
    ->set('title', '你好世界 🌍')
    ->set('lang', 'zh-CN');

echo "Unicode handling:\n";
echo '<div' . $attrs5 . '>国际化内容</div>' . "\n\n";
// Output: <div title="你好世界 🌍" lang="zh-CN">国际化内容</div>

// All output is safe by default
echo "✅ All attribute values are automatically escaped!\n";
echo "✅ No manual escaping needed!\n";
echo "✅ Protection against XSS attacks!\n";
