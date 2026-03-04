---
title: Navigation
description: Building a navigation menu for your site
extends: _layouts.documentation
section: content
---

# Navigation {#navigation}

The navigation menu in the left-hand sidebar is defined using an array in `navigation.php`. Nested pages can be added by using the `children` associative array.

```php
<?php
// navigation.php

return [
    'Getting Started' => [
        'url' => 'docs/getting-started',
        'children' => [
            'Customizing Your Site' => 'docs/customizing-your-site',
            'Navigation' => 'docs/navigation',
            'Algolia DocSearch' => 'docs/algolia-docsearch',
            'Custom 404 Page' => 'docs/custom-404-page',
        ],
    ],
    'Jigsaw Docs' => 'https://jigsaw.tighten.co/docs/installation',
];

// config.php
'navigation' => require_once('navigation.php'),

// blade files
$page->navigation
```
### Versione HEAD

## Collegamenti tra versioni di navigation.md
* [navigation.md](../../../gdpr/docs/navigation.md)
* [navigation.md](../../../xot/docs/navigation.md)
* [navigation.md](../../../ui/docs/navigation.md)
* [navigation.md](../../../cms/docs/blocks/navigation.md)
* [navigation.md](../../../cms/docs/navigation.md)
* [navigation.md](../../../cms/docs/components/navigation.md)

### Versione Incoming

---
