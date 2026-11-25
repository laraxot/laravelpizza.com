---
title: "Topic sushi-to"
type: digest
status: active
qmd: "digest ceiling 100 sushi-to"
---

# Topic sushi-to

Sintesi automatica di 10 documenti (chiave `sushi-to`).

## Tenant Module - SushiToJson Traits Fix Plan

_Fonte: `sushi-to-json-fix-plan.md`_

# Tenant Module - SushiToJson Traits Fix Plan

## Problem Analysis

The `SushiToJson` and `SushiToJsons` traits in the Tenant module are calling undefined methods on models that use these traits. This is causing **90+ PHPStan errors** (65% of all remaining errors).

## Root Cause

The traits define methods that expect to be implemented by the using models, but the models don't implement them:

```php
// Tenant/app/Models/Traits/SushiToJson.php
// Lines 237-324: Calls to undefined methods
$this->getJsonFile();
$this->loadExistingData();
$this->saveToJson();
$this->authId();
$this->ensureDirectoryExists();
$this->findRowIndexById();
```

## Affected Models

### Models Using SushiToJson Trait
1. `Modules\Tenant\Models\TestSushiModel`
2. `Modules\Xot\Models\InformationSchemaTable`
3. `Modules\Geo\Models\Comune`

### Models Using SushiToJsons Trait
1. `Modules\Cms\Models\Attachment`

## SushiToJson/SushiToJsons PHPStan Level 10 Fixes

_Fonte: `sushi-to-json-phpstan-fixes.md`_

# SushiToJson/SushiToJsons PHPStan Level 10 Fixes

## Problem Overview
PHPStan Level 10 cannot discover methods defined in traits when they are called from within the trait itself or from model callbacks.

## Root Cause
PHPStan analyzes static code patterns but cannot dynamically resolve trait method calls that happen:
1. Within the trait itself (SushiToJson calling its own methods)
2. In trait boot callbacks (creating, updating, deleting)
3. In model methods that use trait methods

## Solution: Contratti (Interfacce)

Per risolvere i `method.notFound` nelle closure di boot, i modelli implementano interfacce dedicate e i trait usano type narrowing con `Model&Contract`:

### SushiToJsonContract
Interfaccia in `Modules/Tenant/app/Contracts/SushiToJsonContract.php` con metodi: getJsonFile, loadExistingData, authId, ensureDirectoryExists, saveToJson, findRowIndexById.

Modelli che implementano: Page, Comune, TestSushiModel, InformationSchemaTable.

### SushiToJsonsContract
Interfaccia in `Modules/Tenant/app/Contracts/SushiToJsonsContract.php` con metodo getJsonFile.

Modelli che implementano: Attachment, Menu, PageContent, Section, BaseModelJsons.

### Pattern nei trait
```php
if (! $model instanceof Model || ! $model instanceof SushiToJsonContract) {
    throw new InvalidArgumentException('Model must implement '.SushiToJsonContract::class);
}

## sushi-to-json-trait-analysis

_Fonte: `sushi-to-json-trait-analysis.md`_



## sushi-to-csv

_Fonte: `traits/sushi-to-csv.md`_



## sushi-to-json-completion-summary

_Fonte: `traits/sushi-to-json-completion-summary.md`_



## sushi-to-json-completion-sumy

_Fonte: `traits/sushi-to-json-completion-sumy.md`_



## sushi-to-json-implementation-plan

_Fonte: `traits/sushi-to-json-implementation-plan.md`_



## sushi-to-json-plan

_Fonte: `traits/sushi-to-json-plan.md`_



## sushi-to-json-testing-plan

_Fonte: `traits/sushi-to-json-testing-plan.md`_



## sushi-to-jsons

_Fonte: `traits/sushi-to-jsons.md`_
