---
title: "Topic testing"
type: digest
status: active
qmd: "digest ceiling 100 testing"
---

# Topic testing

Sintesi automatica di 3 documenti (chiave `testing`).

## Testing Documentation

_Fonte: `testing/testing.md`_

# Testing Documentation

## Overview

This document provides testing guidelines and examples for the GDPR module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Gdpr/tests/
├── Feature/
│   ├── (feature tests)
├── Unit/
│   └── (unit tests)
├── TestCase.php
└── Pest.php
```

### Test Files

- **TestCase.php** - Base test case with database configuration
- **Pest.php** - Pest configuration and extensions
- **Feature/** - Feature tests for GDPR functionality
- **Unit/** - Unit tests for GDPR components

## Testing Configuration

## Testing Documentation

_Fonte: `testing.md`_

# Testing Documentation

## Overview

This document provides testing guidelines and examples for the GDPR module in Laraxot.

## Test Structure

### Directory Structure

```
Modules/Gdpr/tests/
├── Feature/
│   ├── (feature tests)
├── Unit/
│   └── (unit tests)
├── TestCase.php
└── Pest.php
```

### Test Files

- **TestCase.php** - Base test case with database configuration
- **Pest.php** - Pest configuration and extensions
- **Feature/** - Feature tests for GDPR functionality
- **Unit/** - Unit tests for GDPR components

## Testing Configuration

## Testing in Gdpr

_Fonte: `wiki/concepts/testing.md`_

# Testing in Gdpr

Questo componente segue lo standard globale di progetto per il testing.

## Pest PHP

Tutti i test devono essere scritti utilizzando **Pest PHP**. L'uso di classi PHPUnit è vietato.

### Convenzioni locali

- Ogni test deve dichiarare `uses()` con la classe TestCase appropriata.
- I test risiedono in `tests/Unit/` e `tests/Feature/`.

### Quality Gate

Prima di ogni commit, i test devono passare i seguenti controlli:
1. Pest: `cd laravel && ./vendor/bin/pest laravel/Modules/Gdpr/tests`
2. PHPStan: `cd laravel && ./vendor/bin/phpstan analyse laravel/Modules/Gdpr/tests --level=5`
3. PHPMD: `phpmd laravel/Modules/Gdpr/tests text phpmd.xml`
