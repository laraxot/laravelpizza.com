---
title: "Topic architecture"
type: digest
status: active
qmd: "digest ceiling 100 architecture"
---

# Topic architecture

Sintesi automatica di 3 documenti (chiave `architecture`).

## Architectural Rules & Guidelines

_Fonte: `architecture.md`_

# Architectural Rules & Guidelines

This module adheres to the **Laraxot Architecture** and **Super Cow Methodology**.

For strict coding standards, Filament extension rules, and PHPStan guidelines, please refer to the central documentation in the **Xot Module**:

-   [Super Cow Methodology](../../xot/docs/super_cow_methodology.md)
-   [PHP Quality Guide](../../xot/docs/php_quality_guide.md)
-   [Filament Extension Rules](../../xot/docs/filament_extension_rules.md)

**Key Principles:**
1.  **DRY & KISS**: Don't repeat yourself, keep it simple.
2.  **Zero Errors**: PHPStan Level 10 compliance is mandatory.
3.  **XotBase**: Always extend `XotBase` classes, never Filament classes directly.
4.  **Translations**: Use `LangServiceProvider` for automatic label resolution.

## Collegamenti correlati
- [Composer merge plugin](composer-merge-plugin.md)

## Contenuto fuso (origine: ARCHITECTURE)

**Models:**
- `BaseModelLang` —
- `LanguageLine` —
- `Translation` —

**Actions:**
- `SyncTranslationsAction` —
- `ValidateTranslationsAction` —

## Architettura — Lang

_Fonte: `bmad/architecture.md`_

# Architettura — Lang

Verificata sul codice il 2026-11-16 (72 PHP in `app/`, 0 Services). Sostituisce la versione precedente, che citava `ValidateTranslationsAction`, `LangResource` e `lang_table`: **nessuno dei tre esiste** ([audit P1-2](./audits/lang-audit.md#p1-2--documentazione-che-contraddice-il-codice)). Scopo: [purpose.md](./purpose.md).

## Componenti reali

| Strato | Elementi |
|---|---|
| Provider | `LangServiceProvider` (`boot` → `translatableComponents()`, `registerFilamentLabel()`), `EventServiceProvider` (`$listen` vuoto), `RouteServiceProvider`; `TranslatorTraitPhpstanProbe` (solo per PHPStan) |
| Risoluzione etichette | `Actions/Filament/AutoLabelAction` applicata da `configureUsing` a Field, Entry, Section, Column, BaseFilter, Step, Action |
| Lettura/scrittura file di lingua | `GetTransPathAction`, `SaveTransAction` (`execute` filtrato, `persist` diretto), `SaveArrayAction` (Xot); morte: `WriteTranslationFileAction`, `ReadTranslationFileAction` |
| Pannello | `TranslationFileResource` (modello Sushi `TranslationFile`), `LocaleSwitcherRefresh`, `LanguageSwitcherWidget`, `View/Components/LanguageSwitcher` |
| Locale | `GetTranslatableLocalesAction`, `GetDefaultTranslatableLocaleAction`, `ListLocaleOptionsAction`, `Datas/LangConfigData` |
| DB | `Translation`, `LanguageLine`, `Post` (11 migration, 3 generazioni) — non scritte in produzione dal modulo (vedi P1-1) |
| Tracker DB (non cablato) | `Adapters/TranslatorAdapter` → `Actions/Translation/RecordMissingTr

## Architettura Modulo Lang

_Fonte: `core/architecture.md`_

# Architettura Modulo Lang

## 🏗️ Panoramica Architetturale

Il modulo Lang è il **modulo specializzato** per la gestione delle lingue, traduzioni e internazionalizzazione del sistema Laraxot.

## 🎯 Principi Fondamentali

### **DRY (Don't Repeat Yourself)**
- **Traduzioni Centralizzate:** Evitare duplicazione di testi
- **Sistema Lingue Unificato:** Gestione uniforme delle traduzioni
- **Template Standardizzati:** Strutture uniformi per tutte le lingue

### **KISS (Keep It Simple, Stupid)**
- **API Semplici:** Metodi facili da usare per le traduzioni
- **Struttura Chiara:** Organizzazione logica dei file di lingua
- **Gestione Lineare:** Processo semplice per aggiungere nuove lingue

## 🏛️ Struttura delle Classi Base

### **BaseModel (Modulo Lang)**
```php
<?php

declare(strict_types=1);

namespace Modules\Lang\Models;

use Modules\Xot\Models\XotBaseModel;
