---
title: "Topic bad-practices"
type: digest
status: active
qmd: "digest ceiling 100 bad-practices"
---

# Topic bad-practices

Sintesi automatica di 3 documenti (chiave `bad-practices`).

## Contenuto fuso da `bad-practices.md`

_Fonte: `bad-practices.md`_

```

```
---
title: "bad practices"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "bad practices"
issues: []
discussions: []

## Contenuto fuso da `bad-practices.md`

# Bad Practices – Media Module

- ❌ **VIOLATE** SVG asset location rule (see `svg-asset-location.md`) using invalid paths
- ❌ **USE** `img/svg` instead of proper `resources/svg/` directory
- ❌ **DUPLICATE** SVG files across modules (violates DRY)
- ❌ **IGNORING** size attributes in SVG markup
- ❌ **RELY** on inline SVG without proper sanitization

## Critical Violation
```php
// ❌ WRONG: SVG in wrong location
<img src="public/images/markers/default.svg">

// ✅ CORRECT: SVG in standard location

## bad-practices

_Fonte: `bmad/bad-practices.md`_

```

```

## Contenuto fuso da `bad-practices.md`

_Fonte: `wiki/bad-practices.md`_

```

```

## Contenuto fuso da `bad-practices.md`

# Bad Practices – Media Module

- ❌ **VIOLATE** SVG asset location rule (see `svg-asset-location.md`) using invalid paths
- ❌ **USE** `img/svg` instead of proper `resources/svg/` directory
- ❌ **DUPLICATE** SVG files across modules (violates DRY)
- ❌ **IGNORING** size attributes in SVG markup
- ❌ **RELY** on inline SVG without proper sanitization

## Critical Violation
```php
// ❌ WRONG: SVG in wrong location
<img src="public/images/markers/default.svg">

// ✅ CORRECT: SVG in standard location
@svg('map-marker.svg')
```
