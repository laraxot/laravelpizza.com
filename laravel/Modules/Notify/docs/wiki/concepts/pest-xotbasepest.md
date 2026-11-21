---
type: note
created: 2026-09-26
updated: 2026-09-26
qmd: "pest xotbasepest"
issues: []
discussions: []
title: pest bootstrap con xotbasepest
description: Come il modulo Notify usa il bootstrap Pest condiviso di Xot senza tests/Support.
document_type: concept
module: Notify
status: active
language: it-IT
updated_at: 2026-08-19
related:
  - ../../../../../../docs/bmad/stories/3.2.notify-xotbasepest-phpstan.story.md
  - ../../../../../../bmad-output/architecture.md
  - ../../../Xot/docs/wiki/concepts/phpstan-pest-bridge-discipline.md
  - ../../../Xot/tests/XotBasePest.php
tags: [pest, xotbasepest, phpstan, testing]
---

# Pest bootstrap con XotBasePest (Notify)

## Perché

Notify non deve duplicare helper già centralizzati in Xot (`tests/Support` è **vietato**, ADR-002). Un solo bootstrap condiviso evita fatal «cannot redeclare» e fa scendere PHPStan su cluster ContactTest.

## Pattern LOCKED (ADR-014 — story 3.6)

Helper cross-modulo `xot*` caricati via **Composer autoload files** in Xot — **non** `require_once`.

Helper dominio Notify in **`tests/Helpers.php`** (Pest 4 auto-load).

## Assert collection → model

```php
// ❌
$this->firstModel($emailContacts, Contact::class);

// ✅
xotAssertFirstModel($emailContacts, Contact::class);
```

## Test file

Ogni file: `uses(\Modules\Notify\Tests\TestCase::class);` — FQCN, dopo gli `import use`.

## Story

Implementazione tracciata: [story 3.2](../../../../../../docs/bmad/stories/3.2.notify-xotbasepest-phpstan.story.md).

## Collegamenti

- [Architect handoff quality testing](../../../../../../docs/chat/architect-handoff-quality-testing-2026-08-19.md)
- [Xot phpstan-pest-bridge-discipline](../../../Xot/docs/wiki/concepts/phpstan-pest-bridge-discipline.md)
