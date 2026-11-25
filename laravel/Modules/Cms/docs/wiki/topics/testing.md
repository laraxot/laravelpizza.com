---
title: "Topic testing"
type: digest
status: active
qmd: "digest ceiling 100 testing"
---

# Topic testing

Sintesi automatica di 3 documenti (chiave `testing`).

## Testing Frontend

_Fonte: `frontoffice/testing.md`_

# Testing Frontend

## Introduzione

Questa sezione descrive le strategie e gli strumenti per il testing del frontend del CMS.

## Test Unitari

### Jest con Vue
```javascript
// tests/unit/ExampleComponent.spec.js
import { mount } from '@vue/test-utils'
import ExampleComponent from '@/components/ExampleComponent.vue'

describe('ExampleComponent', () => {
    it('renders correctly', () => {
        const wrapper = mount(ExampleComponent, {
            props: {
                title: 'Test Title'
            }
        })
        expect(wrapper.text()).toContain('Test Title')
    })
})
```

### Jest con React
```javascript
// tests/unit/ExampleComponent.test.js

## Cms Module Testing Guide

_Fonte: `testing.md`_

# Cms Module Testing Guide

## Overview

This module follows the project's [testing rules](testing-rules.md) and uses Pest PHP as the testing framework.

## Test Structure

```
tests/
  Feature/    # Feature tests
  Unit/       # Unit tests
  Pest.php    # Solo helper: nessun binding del TestCase (vedi sotto)
  PestHelpers.php # Helper globali (autoload-dev.files, senza namespace)
  TestCase.php # Base test case for the module
```

## Binding del TestCase

Ogni file di test che usa l'applicazione o i metodi di `Modules\Cms\Tests\TestCase` lo lega da solo:

```php
use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
```

Mai `uses(...)->in(...)` in `tests/Pest.php`: il runner di root non lo esegue (i test restano senza
applicazione) e con `--test-directory` raddoppia il binding (`TestCaseAlreadyInUse`). Decisione e guardia:

## Testing in Cms

_Fonte: `wiki/concepts/testing.md`_

# Testing in Cms

## Pest PHP

Test auth FO separati per scope: `LoginTest`, `LoginVoltComponentTest`, `LoginWidgetTest`, … — non duplicare con naming inconsistente.

## PHPStan (2026-06-13)

| Fix | Dettaglio |
|-----|-----------|
| `RegisterTest` | Rimosso PHPDoc `@var $this` orfano in placeholder |
| `RegisterComponentTest` | `ReflectionClass::hasMethod('register')` al posto di `method_exists` (già narrowed) |

## Quality gate

```bash
cd laravel
./vendor/bin/pest Modules/Cms/tests
./vendor/bin/phpstan analyse Modules/Cms
```

## Completamento

- [ ] Implementare test Register FO reali (placeholder attuale)
- [ ] Feature test header navigation JSON ([STORY hub](../../../../docs/chat/2026-06-11-st351-phpstan-pest-hub.md))
- [ ] Verificare `<x-page>` solo data bag su pagine CMS-driven
