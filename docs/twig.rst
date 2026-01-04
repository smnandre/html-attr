Twig Integration
================

The HTML Attributes Bundle provides seamless Twig integration, allowing you to 
build and manipulate attributes directly in your templates.

The attributes() Function
--------------------------

The bundle automatically registers a Twig function called ``attributes()`` that 
creates a new attribute collection.

Basic Usage
~~~~~~~~~~~

.. code-block:: twig

    {% set attrs = attributes() %}
    <div{{ attrs }}>Content</div>

The attribute collection can be output directly in templates using the double 
curly braces syntax, which automatically calls ``render()``.

Setting Attributes
------------------

Simple Attributes
~~~~~~~~~~~~~~~~~

.. code-block:: twig

    {% set attrs = attributes()
        .set('id', 'my-element')
        .set('class', 'container')
    %}
    <div{{ attrs }}>Content</div>
    {# Output: <div id="my-element" class="container">Content</div> #}

Chaining Methods
~~~~~~~~~~~~~~~~

.. code-block:: twig

    {% set attrs = attributes()
        .set('id', 'button-1')
        .add('class', 'btn')
        .add('class', 'btn-primary')
        .set('type', 'button')
    %}
    <button{{ attrs }}>Click me</button>

Boolean Attributes
------------------

.. code-block:: twig

    {% set isDisabled = true %}
    {% set isRequired = false %}
    
    {% set attrs = attributes()
        .set('class', 'form-control')
        .toggle('disabled', isDisabled)
        .toggle('required', isRequired)
    %}
    <input{{ attrs }}>
    {# Output: <input class="form-control" disabled> #}

Conditional Attributes
----------------------

Using toggle()
~~~~~~~~~~~~~~

.. code-block:: twig

    {% set attrs = attributes()
        .set('class', 'btn')
        .toggle('disabled', not isEnabled)
        .toggle('hidden', shouldHide)
    %}

Using Twig Conditionals
~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: twig

    {% set attrs = attributes().set('class', 'btn') %}
    
    {% if isPrimary %}
        {% set attrs = attrs.add('class', 'btn-primary') %}
    {% else %}
        {% set attrs = attrs.add('class', 'btn-secondary') %}
    {% endif %}
    
    <button{{ attrs }}>Button</button>

Building Dynamic Classes
------------------------

Simple Class Addition
~~~~~~~~~~~~~~~~~~~~~

.. code-block:: twig

    {% set attrs = attributes()
        .set('class', 'alert')
        .add('class', type == 'error' ? 'alert-danger' : 'alert-info')
    %}
    <div{{ attrs }}>Message</div>

Multiple Conditional Classes
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: twig

    {% set classes = ['card'] %}
    {% if isHighlighted %}
        {% set classes = classes|merge(['card-highlighted']) %}
    {% endif %}
    {% if isCompact %}
        {% set classes = classes|merge(['card-compact']) %}
    {% endif %}
    
    {% set attrs = attributes().set('class', classes|join(' ')) %}
    <div{{ attrs }}>Card content</div>

ARIA Attributes
---------------

.. code-block:: twig

    {% set attrs = attributes()
        .set('role', 'button')
        .aria().set('label', 'Close dialog')
        .aria().set('expanded', isExpanded)
        .aria().set('controls', 'panel-' ~ panelId)
    %}
    <button{{ attrs }}>×</button>

Common ARIA Patterns
~~~~~~~~~~~~~~~~~~~~

Modal Dialog
^^^^^^^^^^^^

.. code-block:: twig

    {# Modal trigger #}
    {% set triggerAttrs = attributes()
        .set('type', 'button')
        .aria().set('haspopup', 'dialog')
        .aria().set('expanded', false)
    %}
    <button{{ triggerAttrs }}>Open Modal</button>
    
    {# Modal container #}
    {% set modalAttrs = attributes()
        .set('role', 'dialog')
        .aria().set('modal', true)
        .aria().set('labelledby', 'modal-title')
        .toggle('hidden', not isOpen)
    %}
    <div{{ modalAttrs }}>
        <h2 id="modal-title">Modal Title</h2>
    </div>

Tab Interface
^^^^^^^^^^^^^

.. code-block:: twig

    {# Tab button #}
    {% set tabAttrs = attributes()
        .set('role', 'tab')
        .aria().set('selected', isActive)
        .aria().set('controls', 'panel-' ~ tabId)
    %}
    <button{{ tabAttrs }}>{{ tabLabel }}</button>
    
    {# Tab panel #}
    {% set panelAttrs = attributes()
        .set('id', 'panel-' ~ tabId)
        .set('role', 'tabpanel')
        .toggle('hidden', not isActive)
    %}
    <div{{ panelAttrs }}>Panel content</div>

Data Attributes
---------------

.. code-block:: twig

    {% set attrs = attributes()
        .data().set('id', product.id)
        .data().set('category', product.category)
        .data().set('price', product.price)
    %}
    <div{{ attrs }}>Product</div>
    {# Output: <div data-id="123" data-category="electronics" data-price="99.99">Product</div> #}

Stimulus Integration
--------------------

Basic Controller
~~~~~~~~~~~~~~~~

.. code-block:: twig

    {% set attrs = attributes()
        .stimulus().setController('dropdown')
        .set('class', 'dropdown')
    %}
    <div{{ attrs }}>
        <button data-action="click->dropdown#toggle">Toggle</button>
        <div data-dropdown-target="menu">Menu items</div>
    </div>

Multiple Controllers
~~~~~~~~~~~~~~~~~~~~

.. code-block:: twig

    {% set attrs = attributes()
        .stimulus().setController('modal')
        .stimulus().addController('fade')
        .stimulus().addController('backdrop')
    %}
    <div{{ attrs }}>Modal content</div>

Actions and Targets
~~~~~~~~~~~~~~~~~~~

.. code-block:: twig

    {# Button with action #}
    {% set buttonAttrs = attributes()
        .set('type', 'button')
        .stimulus().set('action', 'click->modal#open')
    %}
    <button{{ buttonAttrs }}>Open</button>
    
    {# Element with target #}
    {% set contentAttrs = attributes()
        .stimulus().set('target', 'modal.content')
    %}
    <div{{ contentAttrs }}>Content</div>

Values
~~~~~~

.. code-block:: twig

    {% set attrs = attributes()
        .stimulus().setController('carousel')
        .stimulus().set('carousel-interval-value', '5000')
        .stimulus().set('carousel-autoplay-value', 'true')
    %}
    <div{{ attrs }}>Carousel</div>

Component Patterns
------------------

Button Component
~~~~~~~~~~~~~~~~

.. code-block:: twig

    {# templates/components/button.html.twig #}
    {% set attrs = attributes()
        .set('type', type|default('button'))
        .set('class', 'btn')
        .add('class', 'btn-' ~ variant|default('primary'))
        .add('class', size ? 'btn-' ~ size : '')
        .toggle('disabled', disabled|default(false))
    %}
    
    {% if ariaLabel %}
        {% set attrs = attrs.aria().set('label', ariaLabel) %}
    {% endif %}
    
    <button{{ attrs }}>{{ label|default('Button') }}</button>

Usage:

.. code-block:: twig

    {{ include('components/button.html.twig', {
        label: 'Submit',
        variant: 'success',
        size: 'lg',
        ariaLabel: 'Submit form'
    }) }}

Alert Component
~~~~~~~~~~~~~~~

.. code-block:: twig

    {# templates/components/alert.html.twig #}
    {% set attrs = attributes()
        .set('class', 'alert')
        .add('class', 'alert-' ~ type|default('info'))
        .set('role', 'alert')
    %}
    
    {% if dismissible %}
        {% set attrs = attrs
            .add('class', 'alert-dismissible')
            .stimulus().setController('alert')
        %}
    {% endif %}
    
    <div{{ attrs }}>
        {{ message }}
        {% if dismissible %}
            <button type="button" 
                    class="btn-close" 
                    data-action="click->alert#close"
                    aria-label="Close"></button>
        {% endif %}
    </div>

Card Component
~~~~~~~~~~~~~~

.. code-block:: twig

    {# templates/components/card.html.twig #}
    {% set attrs = attributes()
        .set('class', 'card')
        .toggle('card-highlighted', highlighted|default(false))
    %}
    
    {% if link %}
        {% set attrs = attrs
            .data().set('url', link)
            .stimulus().setController('card')
            .stimulus().set('action', 'click->card#navigate')
        %}
    {% endif %}
    
    <div{{ attrs }}>
        <div class="card-body">
            <h5 class="card-title">{{ title }}</h5>
            <p class="card-text">{{ content }}</p>
        </div>
    </div>

Form Input Component
~~~~~~~~~~~~~~~~~~~~

.. code-block:: twig

    {# templates/components/input.html.twig #}
    {% set attrs = attributes()
        .set('type', type|default('text'))
        .set('name', name)
        .set('id', id|default(name))
        .set('class', 'form-control')
        .toggle('is-invalid', error is defined)
        .toggle('required', required|default(false))
    %}
    
    {% if value is defined %}
        {% set attrs = attrs.set('value', value) %}
    {% endif %}
    
    {% if placeholder is defined %}
        {% set attrs = attrs.set('placeholder', placeholder) %}
    {% endif %}
    
    {% if error is defined %}
        {% set attrs = attrs
            .aria().set('invalid', true)
            .aria().set('describedby', id ~ '-error')
        %}
    {% endif %}
    
    <input{{ attrs }}>
    
    {% if error is defined %}
        <div id="{{ id }}-error" class="invalid-feedback">{{ error }}</div>
    {% endif %}

Reusing Attribute Sets
-----------------------

You can build base attribute sets and extend them:

.. code-block:: twig

    {# Base button attributes #}
    {% set baseButton = attributes()
        .set('type', 'button')
        .set('class', 'btn')
    %}
    
    {# Primary button #}
    {% set primaryBtn = baseButton
        .add('class', 'btn-primary')
    %}
    
    {# Danger button #}
    {% set dangerBtn = baseButton
        .add('class', 'btn-danger')
    %}
    
    <button{{ primaryBtn }}>Save</button>
    <button{{ dangerBtn }}>Delete</button>

Merging with Component Props
-----------------------------

When building components, you can accept and merge additional attributes:

.. code-block:: twig

    {# templates/components/icon-button.html.twig #}
    {# 
        Usage: 
        {{ component('icon-button', {
            icon: 'close',
            attrs: attributes().set('data-test', 'close-button')
        }) }}
    #}
    
    {% set defaultAttrs = attributes()
        .set('type', 'button')
        .set('class', 'btn btn-icon')
        .aria().set('label', ariaLabel|default('Icon button'))
    %}
    
    {% if attrs is defined %}
        {# Merge passed attributes with defaults #}
        {% set finalAttrs = defaultAttrs %}
        {% for name, value in attrs.all() %}
            {% if name == 'class' %}
                {% set finalAttrs = finalAttrs.add('class', value) %}
            {% else %}
                {% set finalAttrs = finalAttrs.set(name, value) %}
            {% endif %}
        {% endfor %}
    {% else %}
        {% set finalAttrs = defaultAttrs %}
    {% endif %}
    
    <button{{ finalAttrs }}>
        <i class="icon-{{ icon }}"></i>
    </button>

Working with Forms
------------------

Symfony Forms Integration
~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: twig

    {# Enhance form fields with attributes #}
    {% for field in form %}
        {% set fieldAttrs = attributes()
            .aria().set('required', field.vars.required)
            .toggle('is-invalid', not field.vars.valid)
        %}
        
        {% if not field.vars.valid %}
            {% set fieldAttrs = fieldAttrs
                .aria().set('invalid', true)
                .aria().set('describedby', field.vars.id ~ '_error')
            %}
        {% endif %}
        
        {{ form_widget(field, {'attr': fieldAttrs.all()}) }}
    {% endfor %}

Custom Form Theme
~~~~~~~~~~~~~~~~~

.. code-block:: twig

    {# templates/form/theme.html.twig #}
    {% block form_row %}
        {% set rowAttrs = attributes()
            .set('class', 'form-group')
            .toggle('has-error', not valid)
        %}
        
        <div{{ rowAttrs }}>
            {{ form_label(form) }}
            {{ form_widget(form) }}
            {{ form_errors(form) }}
        </div>
    {% endblock %}

Security
--------

All attribute values are automatically escaped:

.. code-block:: twig

    {% set userInput = '<script>alert("XSS")</script>' %}
    {% set attrs = attributes().set('title', userInput) %}
    <div{{ attrs }}>Safe</div>
    {# Output: <div title="&lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;">Safe</div> #}

.. seealso::
   See :doc:`security` for detailed information on XSS prevention.

Debugging
---------

Inspecting Attributes
~~~~~~~~~~~~~~~~~~~~~

Use the ``all()`` method to see all attributes:

.. code-block:: twig

    {% set attrs = attributes()
        .set('id', 'example')
        .set('class', 'btn')
    %}
    
    {{ dump(attrs.all()) }}
    {# Output: {"id": "example", "class": "btn"} #}

Conditional Debugging
~~~~~~~~~~~~~~~~~~~~~

.. code-block:: twig

    {% if app.debug %}
        {% set attrs = attrs.data().set('debug', 'true') %}
    {% endif %}

Best Practices
--------------

1. **Reusable Components**: Build components that accept attribute collections
2. **Consistent Naming**: Use consistent variable names (``attrs``, ``buttonAttrs``, etc.)
3. **Documentation**: Document expected attributes in component comments
4. **Default Values**: Provide sensible defaults for component attributes
5. **Accessibility**: Always include appropriate ARIA attributes

Example Template Structure
~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: twig

    {# templates/components/card.html.twig #}
    {#
        Card Component
        
        Parameters:
            - title (string, required): Card title
            - content (string, required): Card content
            - highlighted (bool, default: false): Whether to highlight the card
            - attrs (Attributes, optional): Additional attributes for the card container
        
        Example:
            {{ component('card', {
                title: 'My Card',
                content: 'Card content',
                highlighted: true,
                attrs: attributes().data().set('id', '123')
            }) }}
    #}
    
    {% set defaultAttrs = attributes()
        .set('class', 'card')
        .toggle('card-highlighted', highlighted|default(false))
    %}
    
    {# Merge with passed attributes #}
    {% set finalAttrs = attrs is defined ? 
        defaultAttrs : defaultAttrs %}
    
    <div{{ finalAttrs }}>
        <div class="card-body">
            <h5 class="card-title">{{ title }}</h5>
            <p class="card-text">{{ content }}</p>
        </div>
    </div>

Next Steps
----------

- Review :doc:`magic-methods` for convenience methods
- Check :doc:`namespaced-helpers` for ARIA, data, and Stimulus
- Explore :doc:`security` for safe attribute handling
