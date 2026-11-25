---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 92 file oltre target 100.

### `advanced-language-switching-2.md` — Advanced Language Switching Strategies

# Advanced Language Switching Strategies

## Overview
In a healthcare application like `saluteora`, providing a seamless multi-language experience is crucial for accessibility and user satisfaction. This document explores advanced strategies for language switching, building upon our existing URL-based approach.

## Combined URL and Session-Based Language Switching

For optimal user experience and SEO benefits, `saluteora` can implement a hybrid approach combining URL-based language prefixes with session/database storage.

### Benefits
- SEO friendly URLs with language prefix (e.g., `/en/services`)
- Persistent user language preference even after browser closure
- Automatic language detection for new users based on browser settings
- Manual override capability through UI selector

### Imple

### `architecture-2.md` — Lang Module — Architecture

# Lang Module — Architecture

## Purpose
Translation and localization management module

## Core Components

**Models:**
- `BaseModelLang` —
- `LanguageLine` —
- `Translation` —

**Actions:**
- `SyncTranslationsAction` —
- `ValidateTranslationsAction` —

**Filament Resources:**
- `LangResource` — Main admin resource

## Database Schema

### `automatic-translations-2.md` — Traduzioni Automatiche con LangServiceProvider

# Traduzioni Automatiche con LangServiceProvider

## Regola Fondamentale
In il progetto, **NON utilizzare mai** il metodo `->label()` nei componenti Filament. Le etichette vengono gestite automaticamente dal `LangServiceProvider` attraverso i file di traduzione.

## Come Funziona

### 1. Registrazione Automatica
Il `LangServiceProvider` registra automaticamente tutti i componenti Filament (Field, Column, Filter, Step, ecc.) e applica le traduzioni basate su chiavi generate automaticamente.

```php
// Questo viene fatto automaticamente dal LangServiceProvider
Field::configureUsing(function (Field $component) {
    $component = app(AutoLabelAction::class)->execute($component);
    // ...
});
```

### 2. Generazione delle Chiavi di Traduzione
Le chiavi di traduzione vengono generate automatic

### `bmad/cms-link-2.md` — Collegamento al Modulo Cms

# Collegamento al Modulo Cms

Questo documento descrive le relazioni e i collegamenti tra il modulo Lang e il modulo Cms per quanto riguarda le traduzioni e l'internazionalizzazione.

## Traduzioni nei Componenti Filament

Il modulo Lang fornisce il sistema di traduzione utilizzato dal modulo Cms nei suoi componenti Filament. È fondamentale seguire le [regole per le traduzioni in Filament](../filament-translations-2.md) quando si lavora con i componenti nel modulo Cms.

## Convenzioni di Namespace e Struttura

Il modulo Cms segue specifiche convenzioni di namespace documentate in [Convenzioni Namespace Filament](../../../Cms/docs/convenzioni-namespace-filament-2.md) che si integrano con il sistema di traduzioni di questo modulo.

## Punti di Integrazione

- **LangServiceProvider**: Gestisc

### `cms-link-2.md` — Collegamento al Modulo Cms

# Collegamento al Modulo Cms

Questo documento descrive le relazioni e i collegamenti tra il modulo Lang e il modulo Cms per quanto riguarda le traduzioni e l'internazionalizzazione.

## Traduzioni nei Componenti Filament

Il modulo Lang fornisce il sistema di traduzione utilizzato dal modulo Cms nei suoi componenti Filament. È fondamentale seguire le [regole per le traduzioni in Filament](./filament-translations.md) quando si lavora con i componenti nel modulo Cms.

## Convenzioni di Namespace e Struttura

Il modulo Cms segue specifiche convenzioni di namespace documentate in [Convenzioni Namespace Filament](../../Cms/docs/convenzioni-namespace-filament.md) che si integrano con il sistema di traduzioni di questo modulo.

## Punti di Integrazione

- **LangServiceProvider**: Gestisce automa

### `consolidation-plan-2.md` — Lang Module Docs Consolidation Plan


# Lang Module Docs Consolidation Plan

**Phase:** 2d Aggressive Merge  
**Current:** 579 total files (339 .md at root)  
**Target:** ≤30 files at root  
**Strategy:** Delete duplicates → Consolidate by topic → Move research to wiki/

---

title: "CONSOLIDATION PLAN"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "CONSOLIDATION PLAN"
issues: []
discussions: []
## Quick Stats


### `consolidation-plan-4.md` — Lang Module Docs Consolidation Plan


# Lang Module Docs Consolidation Plan

**Phase:** 2d Aggressive Merge  
**Current:** 579 total files (339 .md at root)  
**Target:** ≤30 files at root  
**Strategy:** Delete duplicates → Consolidate by topic → Move research to wiki/

---

title: "CONSOLIDATION PLAN"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "CONSOLIDATION PLAN"
issues: []
discussions: []
## Quick Stats


### `contracts/template-2.md` — <operazione> — contratto comportamentale


# <operazione> — contratto comportamentale

Classe o superficie: `<FQCN>`  
Riferimento nel codice: `@contract docs/contracts/<file>.md`

## Input

- <input e validazione>

## Output

- <risultato osservabile>

## Invarianti

| ID | Regola | Verifica |
|---|---|---|
| `<MODULE>-INV-1` | <regola che deve restare vera> | <test o controllo ripetibile> |


### `correzioni-errori-sintassi-2.md` — Correzioni Errori Sintassi File Traduzione - Gennaio 2025

# Correzioni Errori Sintassi File Traduzione - Gennaio 2025

## Riepilogo Problemi Risolti

### Errori Critici Identificati

1. **Dichiarazione `declare(strict_types=1)` posizionata erroneamente**
   - **File**: `laravel/Modules/Chart/lang/it/mixed_chart.php`
   - **Problema**: `declare(strict_types=1);` posizionato dopo `return`
   - **Soluzione**: Spostato prima di `return`

2. **Traduzioni non tradotte (chiavi inglesi)**
   - **File**: Tutti i file corretti
   - **Problema**: Valori impostati a chiavi non tradotte (es. `'label' => 'id'`)
   - **Soluzione**: Sostituite con traduzioni appropriate in italiano

3. **Struttura array non conforme**
   - **Problema**: Indentazione inconsistente e struttura non standard
   - **Soluzione**: Standardizzata struttura con indentazione coerente


### `correzioni-errori-sintassi-3.md` — Correzioni Errori Sintassi File Traduzione - Gennaio 2025

# Correzioni Errori Sintassi File Traduzione - Gennaio 2025

## Riepilogo Problemi Risolti

### Errori Critici Identificati

1. **Dichiarazione `declare(strict_types=1)` posizionata erroneamente**
   - **File**: `laravel/Modules/Chart/lang/it/mixed_chart.php`
   - **Problema**: `declare(strict_types=1);` posizionato dopo `return`
   - **Soluzione**: Spostato prima di `return`

2. **Traduzioni non tradotte (chiavi inglesi)**
   - **File**: Tutti i file corretti
   - **Problema**: Valori impostati a chiavi non tradotte (es. `'label' => 'id'`)
   - **Soluzione**: Sostituite con traduzioni appropriate in italiano

3. **Struttura array non conforme**
   - **Problema**: Indentazione inconsistente e struttura non standard
   - **Soluzione**: Standardizzata struttura con indentazione coerente


### `docs-naming-convention-fix-2.md` — Correzione Convenzione Naming Cartelle Docs - Gennaio 2025

# Correzione Convenzione Naming Cartelle Docs - Gennaio 2025

## Data Aggiornamento
2025-01-27

## Problema Identificato
Le cartelle `docs` contenevano file e sottocartelle con caratteri maiuscoli, violando la convenzione di utilizzare solo caratteri minuscoli (eccetto `README.md`).

## Convenzione Applicata
- ✅ Tutti i file devono utilizzare solo caratteri minuscoli
- ✅ Eccetto `README.md` che può contenere caratteri maiuscoli
- ✅ Tutte le sottocartelle devono utilizzare solo caratteri minuscoli
- ✅ Separatori: trattini (`-`) o underscore (`_`)

## File Corretti

### Modulo Xot
- ✅ `naming-conventions.md` → `naming-conventions-uppercase.md`
- ✅ `php-strict-types.md` → `php-strict-types.md`
- ✅ `testing_best_practices.md` → `testing-best-practices-uppercase.md`

### `documentation-link-conventions-2.md` — Convenzioni per i Link nella Documentazione

# Convenzioni per i Link nella Documentazione

## Regole Fondamentali per i Link Markdown

### 1. Utilizzare Sempre Percorsi Relativi

I collegamenti nei file di documentazione devono **sempre** utilizzare percorsi relativi, mai percorsi assoluti.

✅ **CORRETTO**:
```markdown
[Regole Generali](../../Xot/docs/translations.md)
[Best Practices](translation-keys-best-practices-2.md)
```

❌ **ERRATO**:
```markdown
[Regole Generali](/var/www/html/<directory progetto>/laravel/Modules/Xot/docs/translations.md)
[Best Practices](/var/www/html/<directory progetto>/laravel/Modules/Lang/docs/translation-keys-best-practices-2.md)
```


### `dry-kiss-analysis-2.md` — DRY & KISS Analysis - Modulo Lang

# DRY & KISS Analysis - Modulo Lang

**Data:** 15 Ottobre 2025
**DRY Score:** ✅ 98%
**KISS Score:** ✅ 95%

## ✅ Stato Attuale

### BaseModel Eccellente
```php
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'lang';  // SOLO questo!
}
```

**Righe:** 6
**DRY Level:** ✅ 99%

## 🎯 Raccomandazioni

### `duplicate-methods-2.md` — Metodi duplicati — Lang

# Metodi duplicati — Lang

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **87**
- Metodi duplicati trovati: **32**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `execute` | 11 | candidato a trait/helper |
| `getHeaderActions` | 6 | candidato a trait/helper |
| `casts` | 5 | candidato a trait/helper |
| `getFormSchema` | 4 | candidato a trait/helper |
| `render` | 4 | candidato a trait/helper |
| `run` | 4 | candidato a trait/helper |
| `up` | 4 | candidato a trait/helper |
| `changeLanguage` | 3 | candidato a trait/helper |
| `create` | 3 | candidato a trait/helper |

### `english-translation-audit-2.md` — Audit Traduzioni Inglesi - <main module>

# Audit Traduzioni Inglesi - <main module>

## Panoramica

Questo documento traccia l'audit e la correzione delle traduzioni inglesi nei file di lingua del progetto <main module>. Molti file nelle cartelle `lang/en/` contengono ancora testo in italiano che deve essere tradotto.

## Problemi Identificati

### File Completamente in Italiano

1. **Modules/UI/lang/en/opening_hours.php** ✅ CORRETTO
   - Status: Tradotto completamente
   - Conteneva: Tutto il testo in italiano
   - Risolto: 2025-01-06

2. **Modules/Notify/lang/en/test_smtp.php** ✅ CORRETTO
   - Status: Tradotto completamente
   - Conteneva: Tutto il testo in italiano
   - Risolto: 2025-01-06


### `errori-comuni-traduzione-2.md` — Errori comuni nei file di traduzione

# Errori comuni nei file di traduzione

## Errori di sintassi critici identificati

### 1. Dichiarazione `declare(strict_types=1)` posizionata erroneamente

**Errore comune**: La dichiarazione `declare(strict_types=1);` viene posizionata dopo il `return` o in posizione errata.

**Esempio di errore**:
```php
<?php 
return [

declare(strict_types=1);  // ERRORE: dopo return
  'navigation' => [
    'label' => 'Navigation Label',
  ],
);
```


### `filament-integration-2.md` — Integrazione di mcamara/laravel-localization con Filament

# Integrazione di mcamara/laravel-localization con Filament

## Indice
1. [Introduzione](#introduzione)
2. [Configurazione Iniziale](#configurazione-iniziale)
   - [Installazione di Filament](#installazione-di-filament)
   - [Configurazione di Laravel-Localization](#configurazione-di-laravel-localization)
3. [Traduzione delle Risorse Filament](#traduzione-delle-risorse-filament)
4. [Middleware per Filament](#middleware-per-filament)
5. [Plugin per la Gestione delle Lingue](#plugin-per-la-gestione-delle-lingue)
6. [Testing](#testing)
7. [Best Practice](#best-practice)
8. [Risoluzione Problemi](#risoluzione-problemi)

## Introduzione

L'integrazione di `mcamara/laravel-localization` con Filament richiede un approccio specifico per garantire che il pannello di amministrazione supporti corrett

### `filament-label-2.md` — Gestione automatica delle label in Filament tramite LangServiceProvider

# Gestione automatica delle label in Filament tramite LangServiceProvider

## Funzionamento
- LangServiceProvider applica automaticamente la label corretta tramite AutoLabelAction a tutte le colonne, actions e fields Filament.
- Non serve mai usare ->label(): la label viene ricavata dalla chiave di traduzione secondo convenzione.
- Se la traduzione non esiste, il sistema può crearla o segnalarla (fallback).

## Pattern
- Label, heading, help e placeholder SOLO in file di traduzione modulo.
- Convenzione chiavi: `modulo.resource.fields.campo.label` o `modulo.resource.actions.azione.label`.
- Nessuna label hardcoded nei file Filament.

## Anti-pattern
- Uso di ->label() nei componenti Filament.
- Label hardcoded.

## Test di regressione
- Test statico che cerca ->label( nei file Filament.
- 

### `filament-translations-2.md` — Regole per le Traduzioni in Filament

# Regole per le Traduzioni in Filament

> **Regola fondamentale:** MAI utilizzare il metodo `->label()` nei componenti Filament, specialmente nei Blocks. Le etichette sono gestite automaticamente dal LangServiceProvider.

# ⚠️ Regola fondamentale: MAI usare chiavi che terminano con `.navigation` nei file di traduzione

- Usa sempre la struttura array per navigation:
  ```php
  'navigation' => [
      'label' => 'Gestione Pazienti',
      'group' => 'Pazienti',
      'icon' => 'heroicon-o-user-group',
      'color' => 'primary',
  ],
  ```
- **Esempio ERRATO:**
  ```php
  'group' => 'patient.navigation',
  'label' => 'patient.navigation',
  ```

### `frameworks-2.md` — Lang — Framework Integration Notes


# Lang — Framework Integration Notes

Integration guidelines for caveman, graphify, bmad-method, headroom, ponytail.

**Status:** Awaiting Phase 3 framework research results

## Code Review (caveman)

Surgical editing patterns:
- Single-file edits encouraged
- Multi-file refactors discouraged
- Mechanical renames via caveman agent

## Architecture (graphify)

Dependency analysis:
- Module dependencies: [TBD — graphify analysis]
- Circular deps: [TBD]
- Cross-theme usage: [TBD]

### `git-conflict-resolution-2.md` — Audit collisioni Git committate in bashscripts


# Audit collisioni Git committate in bashscripts

Risoluzione deterministica per singolo blocco: lato non vuoto, superset, metadata `updated` più recente, quindi HEAD come spareggio conservativo.

| File | Blocchi | Decisioni | SHA-256 prima → dopo |
|---|---:|---|---|
| `laravel/Modules/Lang/docs/code-quality-improvement-report.md` | 1 | shorter_tiebreak=1 | `5baf0963b27d` → `b23a2ea4e1cc` |

### `integration-mc-laravel-localization-2.md` — Integrazione di mcamara/laravel-localization

# Integrazione di mcamara/laravel-localization

Questo documento descrive come integrare e configurare il pacchetto `mcamara/laravel-localization` nel progetto <main module>.

## Panoramica

Il pacchetto `mcamara/laravel-localization` fornisce un sistema avanzato per la gestione delle lingue in applicazioni Laravel, con supporto a:

- Gestione delle route localizzate
- Middleware per il rilevamento della lingua
- Supporto a domini personalizzati per lingua
- Generazione di URL localizzati
- Supporto a sessioni e cookie per la persistenza della lingua

## Configurazione Richiesta

### 1. Installazione

```bash
composer require mcamara/laravel-localization

### `lang-link-2.md` — Collegamento alle Traduzioni del Modulo Chart

# Collegamento alle Traduzioni del Modulo Chart

Questo modulo utilizza le traduzioni centralizzate nella cartella [Lang](../../Lang/docs/).

Consulta la documentazione delle traduzioni:
- [Introduzione alle Traduzioni](../../Lang/docs/introduction.md)
- [Struttura delle Traduzioni](../../Lang/docs/structure.md)
- [Gestione dei File di Lingua](../../Lang/docs/module_lang.md)

## Collegamento Bidirezionale

Per ogni risorsa o campo localizzato, vedi anche il file corrispondente in questo modulo e la relativa sezione in [Lang](../../Lang/docs/).

> Aggiorna entrambi i riferimenti se aggiungi nuove chiavi di traduzione o modifichi la struttura.

## Collegamenti tra versioni di lang-link.md
* [lang-link.md](laravel/Modules/Chart/docs/lang-link.md)
* [lang-link.md](laravel/Modules/Reporting/doc

### `livewire-integration-2.md` — Integrazione di mcamara/laravel-localization con Livewire

# Integrazione di mcamara/laravel-localization con Livewire

## Indice
1. [Introduzione](#introduzione)
2. [Configurazione Iniziale](#configurazione-iniziale)
   - [Installazione di Livewire](#installazione-di-livewire)
   - [Configurazione di Laravel-Localization](#configurazione-di-laravel-localization)
3. [Middleware per Livewire](#middleware-per-livewire)
4. [Componenti Livewire Localizzati](#componenti-livewire-localizzati)
5. [Gestione dei Form](#gestione-dei-form)
6. [Testing](#testing)
7. [Best Practice](#best-practice)
8. [Risoluzione Problemi](#risoluzione-problemi)

## Introduzione

L'integrazione tra `mcamara/laravel-localization` e Livewire richiede un'attenzione particolare alla gestione dello stato dell'applicazione e al ciclo di vita dei componenti. Questa guida ti mostrerà

### `localizing-dates-and-currencies-2.md` — Localizzazione di Date e Valute

# Localizzazione di Date e Valute

## Introduzione

La localizzazione di date e valute è un aspetto cruciale per un'applicazione multilingue come `saluteora`. Tradurre manualmente mesi, giorni e simboli di valuta per ogni lingua sarebbe un lavoro enorme. Fortunatamente, Laravel e PHP offrono strumenti potenti come Carbon per le date e `NumberFormatter` per le valute, che gestiscono automaticamente la formattazione in base alla lingua. Questa documentazione, basata sul corso di Laravel Daily, esplora come implementare queste funzionalità nel progetto `saluteora`.

## Localizzazione di Date con Carbon

Carbon, la libreria di gestione delle date integrata in Laravel, rende la localizzazione delle date estremamente semplice. È sufficiente impostare il locale di Carbon in base alla lingua corre

### `localizing-dates-currencies-2.md` — Localizzazione di Date e Valute

# Localizzazione di Date e Valute

## Introduzione

La localizzazione di date e valute è un aspetto cruciale per un'applicazione multilingue come `saluteora`. Questa documentazione, basata sul corso di Laravel Daily, esplora come utilizzare Carbon per localizzare date e differenze temporali, e la classe `NumberFormatter` di PHP per formattare valute in base alla lingua corrente dell'utente.

## Localizzazione di Date con Carbon

Carbon, la libreria di gestione delle date integrata in Laravel, rende semplice la localizzazione delle date. È sufficiente impostare il locale di Carbon in base alla lingua corrente dell'applicazione.

**Configurazione in `AppServiceProvider`**:
```php
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /

### `mcp-server-recommended-2.md` — MCP Server Consigliati per il Modulo Lang

# MCP Server Consigliati per il Modulo Lang

## Scopo del Modulo
Gestione traduzioni, localizzazione e internazionalizzazione.

## Server MCP Consigliati
- `filesystem`: Per gestione file di traduzione e risorse linguistiche.
- `memory`: Per caching temporaneo delle traduzioni.

## Configurazione Minima Esempio
```json
{
  "mcpServers": {
    "filesystem": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-filesystem"] },
    "memory": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-memory"] }
  }
}
```

## Note

### `metodi-duplicati-analisi-2.md` — Metodi Duplicati — Analisi Lang


# Metodi Duplicati — Analisi Lang

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Lang**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Models/Policies/LangBasePolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `get` (11 occorrenze)

**Moduli coinvolti:** Lang, Media, Notify, Seo, Xot

### `migration-best-practices-2.md` — Best Practices per le Migrazioni - Modulo Lang

# Best Practices per le Migrazioni - Modulo Lang

## Panoramica

Questo documento descrive le best practices specifiche per le migrazioni del modulo Lang, che gestisce il sistema di traduzioni multilanguage del progetto.

## Struttura Standard delle Migrazioni

### Template Base

Tutte le migrazioni del modulo Lang devono seguire questo template:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Translation;
use Modules\Xot\Database\Migrations\XotBaseMigration;

### `migration-corrections-summary-2.md` — Correzioni Migrazione - Modulo Lang

# Correzioni Migrazione - Modulo Lang

## Problema Identificato

La migrazione `2025_03_20_000001_create_language_lines_table.php` non seguiva gli standard del progetto.

## Errori Originali

### ❌ Mancanza delle Proprietà Obbligatorie

```php
return new class extends XotBaseMigration {
    protected ?string $model_class = Translation::class;
    // Mancavano: $table e $connection
```

### ❌ Struttura Non Standard

- Mancava la documentazione completa
- Mancavano le verifiche di esistenza colonne

### `migration-patterns-2.md` — Migration Patterns for Lang Module

# Migration Patterns for Lang Module

## Overview

This document outlines the correct migration patterns to follow when creating database migrations for the Lang module and all other modules in the TechPlanner project.

## Critical Rule: Use XotBaseMigration

**ALL module migrations MUST extend `XotBaseMigration` instead of the standard Laravel `Migration` class.**

### Correct Pattern

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Translation;
use Modules\Xot\Database\Migrations\XotBaseMigration;

### `migrations-2.md` — Migrations — Lang Module


# Migrations — Lang Module

Questo documento descrive le migrazioni nel modulo Lang e come mantengono la conformità con il pattern XotBaseMigration.

## Philosophy

Nel modulo Lang, ogni modello database-backed ha esattamente una migrazione corrispondente:

| Model | Migration | Status |
|-------|-----------|--------|
| `LanguageLine` | `2024_03_20_000001_create_language_lines_table.php` | ✅ DB-backed |
| `Post` | `2026_01_21_211814_create_posts_table.php` | ✅ DB-backed |
| `Translation` | `2026_01_21_211815_create_translations_table.php` | ✅ DB-backed |
| `TranslationFile` | *none* (uses Sushi trait) | ✅ In-memory |

**Parity Rule**: `TranslationFile` estende `BaseModel` con il trait `Sushi` (in-memory model), quindi non richiede una migrazione. Le 3 migrazioni coprono interamente i 3 mo

### `model-translations-2.md` — Model Translations in `saluteora`

# Model Translations in `saluteora`

## Overview
In a healthcare application like `saluteora`, translating model data such as medical content, patient information, or service descriptions is critical for user accessibility across different languages. This document outlines how to implement model translations without packages and explores package-based solutions for more complex needs.

## Approach 1: Manual Model Translations (Without Packages)

This approach involves creating separate tables for translatable content, ensuring full control over the database structure and translation logic.

### Database Structure
- **Base Table**: Stores non-translatable data (e.g., IDs, dates).
- **Translation Table**: Stores translatable fields linked to the base table by ID and locale.

Example for a `S

### `modelli-factory-seeder-analisi-2.md` — Analisi Modelli, Factory e Seeder - Modulo Lang

# Analisi Modelli, Factory e Seeder - Modulo Lang

## Panoramica
Questo documento analizza tutti i modelli del modulo Lang verificando la presenza di factory e seeder corrispondenti, identificando modelli non utilizzati nella business logic principale.

## Modelli Attivi e Business Logic

### Modelli Core Translation (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Translation** | ✅ TranslationFactory | ✅ LangDatabaseSeeder | Core - Traduzioni dinamiche |
| **TranslationFile** | ✅ TranslationFileFactory | ❌ | Core - File traduzioni |
| **Post** | ✅ PostFactory | ❌ | Content - Contenuti multilingua |

### Modelli Base (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|--

### `modules-link-2.md` — Collegamenti ai Moduli che utilizzano le Traduzioni

# Collegamenti ai Moduli che utilizzano le Traduzioni

Questa pagina elenca, per ogni modulo, la presenza di un file di collegamento alle traduzioni centralizzate.

## Moduli con collegamento

- [Activity](../../Activity/docs/lang-link.md)
- [Chart](../../Chart/docs/lang-link.md)
- [Cms](../../Cms/docs/lang-link.md)
- [Dental](../../Dental/docs/lang-link.md)
- [Gdpr](../../Gdpr/docs/lang-link.md)
- [Job](../../Job/docs/lang-link.md)
- [Media](../../Media/docs/lang-link.md)
- [Notify](../../Notify/docs/lang-link.md)
- [Patient](../../Patient/docs/lang-link.md)
- [Reporting](../../Reporting/docs/lang-link.md)
- [Tenant](../../Tenant/docs/lang-link.md)
- [UI](../../UI/docs/lang-link.md)
- [User](../../User/docs/lang-link.md)
- [Xot](../../Xot/docs/lang-link.md)

### `performance-optimization-2.md` — Performance Optimization — Module **Lang**


# Performance Optimization — Module **Lang**

## Ottimizzazioni Applicate

### 1. On-Demand Loading (principale)

**Prima**: Bootstrap caricava tutte le rules (50K+ token)
**Dopo**: Carico solo what's needed (~2K startup)

\`\`\`diff
- 150+ rules embeddate in AGENTS.md
+ 0 rules embeddate — tutte on-demand
\`\`\`

### 2. Cache Esterna al Repo

\`\`\`diff
- .cache/ (8KB nel repo)
+ ~/.cache/qmd-cache/ (fuori da git)

### `permessi-e-errori-filesystem-2.md` — Gestione Permessi e Errori Filesystem su File di Lingua (Lang)

# Gestione Permessi e Errori Filesystem su File di Lingua (Lang)

> **Backlink:** [Indice e collegamenti root](../../../docs/links.md)

## Problema

Durante operazioni di scrittura su file come `lang_service.php` in `Modules/Lang/lang/it/`, può comparire l'errore:

```
file_put_contents(/var/www/html/ptvx/laravel/Modules/Lang/lang/it/lang_service.php): Failed to open stream: Permission denied
```

## Causa

- Il file o la cartella ha permessi o proprietà non compatibili con l'utente del webserver (`www-data` su sistemi Linux tipici).
- Spesso il file viene creato o modificato da un utente diverso (es. sviluppatore locale), causando mismatch di ownership.

## Soluzione definitiva

1. **Impostare la proprietà corretta:**

### `permessi-errori-filesystem-2.md` — Gestione Permessi e Errori Filesystem su File di Lingua (Lang)

# Gestione Permessi e Errori Filesystem su File di Lingua (Lang)

> **Backlink:** [Indice e collegamenti root](../../../docs/links.md)

## Problema

Durante operazioni di scrittura su file come `lang_service.php` in `Modules/Lang/lang/it/`, può comparire l'errore:

```
file_put_contents(/var/www/html/ptvx/laravel/Modules/Lang/lang/it/lang_service.php): Failed to open stream: Permission denied
```

## Causa

- Il file o la cartella ha permessi o proprietà non compatibili con l'utente del webserver (`www-data` su sistemi Linux tipici).
- Spesso il file viene creato o modificato da un utente diverso (es. sviluppatore locale), causando mismatch di ownership.

## Soluzione definitiva

1. **Impostare la proprietà corretta:**

### `permessi-lang-2.md` — Gestione Permessi e Proprietà per File di Lingua (`lang/it/`)

# Gestione Permessi e Proprietà per File di Lingua (`lang/it/`)

## Problema

Durante la scrittura di file di lingua tramite PHP (es. `file_put_contents(...)`), può comparire l’errore:

```
file_put_contents(/var/www/html/ptvx/laravel/Modules/Lang/lang/it/lang_service.php): Failed to open stream: Permission denied
```

## Causa

Il file o la cartella di destinazione non è scrivibile dall’utente che esegue PHP (tipicamente `www-data`). Spesso accade perché i file sono stati creati o modificati da un utente diverso (es. `msottana`) e hanno permessi troppo restrittivi.

## Soluzione Definitiva

1. **Uniformare la proprietà** di tutti i file e cartelle di `Modules/Lang/lang/it/` a `www-data:www-data`:
   ```bash
   sudo chown -R www-data:www-data /var/www/html/ptvx/laravel/Modules/Lang/lang/it

### `philosophy-2.md` — Lang Module: A Philosophy of Localization


# Lang Module: A Philosophy of Localization

> **The Essence**: Italiano in UI, English in code. Structured keys, zero hardcoded labels in Filament, unified translations across 20 modular subsystems.

---

## RELIGIONE (i18n Dogmas)

The Lang module enshrines five immutable principles:

### 1. The PHP File Hierarchy is Sacred

Translations live in **native PHP arrays**, not databases, not JSON. Why?

- **Immutability by revision control**: Changes to translations are Git-tracked, audited, versioned.
- **Structure scales**: Nested keys allow context — `patient.profile.name.label` is unambiguous across modules.
- **Performance**: No database round-trips. Artisan can validate file syntax before deploy.
- **Simplicity**: A translator receives `/lang/en/patient.php`, edits values, returns it. 

### `phpstan-fixes.md` — PHPStan Compliance Documentation


# PHPStan Compliance Documentation

## Overview

Documenta tutti i fix di compliance PHPStan implementati per raggiungere 0 errori a livello max.

## Errori Corretti

### 1. TranslationFileResource - Lang Module

**File**: `app/Filament/Resources/TranslationFileResource/Pages/EditTranslationFile.php`

**Errori Originali**:
- `parameter.type` su `$data['content']`
- `return.type` per `makeFromArray()`
- `identifier: missingType.iterableValue`

**Soluzioni Implementate**:
```php

### `plural-date-localization-2.md` — Gestione di Forme Plurali e Localizzazione di Date/Valute in Laravel

# Gestione di Forme Plurali e Localizzazione di Date/Valute in Laravel

## Indice
1. [Introduzione](#introduzione)
2. [Gestione delle Forme Plurali](#gestione-delle-forme-plurali)
   - [Utilizzo di trans_choice()](#utilizzo-di-trans_choice)
   - [Sintassi per i Plurali](#sintassi-per-i-plurali)
   - [Esempi Pratici](#esempi-pratici)
3. [Localizzazione di Date e Orari](#localizzazione-di-date-e-orari)
   - [Configurazione di Carbon](#configurazione-di-carbon)
   - [Formattazione delle Date](#formattazione-delle-date)
   - [Differenze tra Date](#differenze-tra-date)
4. [Localizzazione di Valute e Numeri](#localizzazione-di-valute-e-numeri)
   - [Utilizzo di NumberFormatter](#utilizzo-di-numberformatter)
   - [Helper Personalizzati](#helper-personalizzati)
5. [Implementazione nel Progetto](#i

### `pluralization-and-localization-2.md` — Plurale/Singolare e Localizzazione Date/Valute

# Plurale/Singolare e Localizzazione Date/Valute

## Pluralizzazione

### Uso di `trans_choice()` e `@choice()`
- Per messaggi che variano in base al conteggio, usa `trans_choice()` o la direttiva Blade `@choice()`.
- Sintassi tipica in PHP:
  ```php
  // lang/en/messages.php
  return [
      'newMessageIndicator' => '{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages',
  ];
  ```
- In Blade:
  ```blade
  @choice('messages.newMessageIndicator', $messagesCount)
  ```
- Sintassi delle regole plurali:
  - `{0}`: caso zero
  - `{1}`: caso singolare

### `prd-2.md` — Product Requirements Document (PRD) - Lang Module

# Product Requirements Document (PRD) - Lang Module

**Module**: Lang
**Version**: 1.0
**Status**: Draft
**Author**: Product Team

---

## Document Control

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2026-08-04 | Product Team | Initial draft |

---

## 1. Executive Summary

### 1.1 Problem Statement

### `product-launch-plan-2.md` — Lang Module - Product Launch Plan

# Lang Module - Product Launch Plan

**Module:** Lang  
**Version:** 1.0.0  
**Last Updated:** March 12, 2026  
**Owner:** Product Team

---

## Launch Objectives

1. **Product:** Deploy multi-language support
2. **Coverage:** Support 2 languages (EN, ES)
3. **User:** Auto-detect and switch language
4. **Quality:** 90%+ translation accuracy

---

## Pre-Launch Checklist


### `product-roadmap-2.md` — Lang Module - Product Roadmap

# Lang Module - Product Roadmap

**Module:** Lang  
**Version:** 1.0.0  
**Last Updated:** March 12, 2026  
**Owner:** Product Team  
**Status:** In Development

---

## Vision Statement

To provide **comprehensive internationalization (i18n) and localization (l10n) capabilities** that enable seamless multi-language experiences, making the platform accessible to users worldwide.

### Vision Pillars

1. **Global Reach:** Support all major languages
2. **Quality Translations:** Accurate, natural translations
3. **Easy Management:** Simple translation workflows
4. **Auto-Detection:** Smart language selection

### `product-strategy-2.md` — Lang Module - Product Strategy

# Lang Module - Product Strategy

**Module:** Lang  
**Version:** 1.0.0  
**Last Updated:** March 12, 2026  
**Owner:** Product Team

---

## Executive Summary

The Lang module enables global accessibility through comprehensive internationalization, allowing the platform to serve users in their preferred language.

---

## Market Analysis

### TAM / SAM / SOM

| Segment | TAM | SAM | SOM (2028) |

### `project-structure-2.md` — Project Structure — Module **Lang**


# Project Structure — Module **Lang**

## Directory Structure

\`\`\`
./laravel/Modules/Lang/docs/
├── wiki/                          # Knowledge base locale (LLM Wiki)
│   ├── index.md                  # Master catalog
│   ├── log.md                    # Activity log
│   ├── concepts/                 # Topic/theme pages
│   ├── entities/                 # Organization/person pages
│   ├── rules/                    # ⚠️ 151+ regole progettuali
│   │   ├── 00-INDEX.md          # Indice regole
│   │   ├── 00-TRIGGER_MAP.md    # Trigger map (link a globale)
│   │   └── *.md                 # Regole specifiche modulo
│   ├── skills/                   # Skill progettuali
│   │   ├── index-3.md
│   │   └── *.md
│   ├── commands/                 # Comandi progettuali

### `qmd-setup-2.md` — QMD Setup per Module **Lang**


# QMD Setup per Module **Lang**

## Configurazione QMD per Questo Module

### Collection Configuration

Il progetto usa una collection QMD centralizzata in `.qmd/index.yml` che include tutti i moduli.

### Ricerca Locale vs Globale

**Ricerca locale** (solo questo modulo):
\`\`\`bash
qmd search "<topic>" -c lang
# Cerca solo in ./laravel/Modules/Lang/docs/wiki/
\`\`\`

**Ricerca globale** (tutto il progetto):
\`\`\`bash
qmd search "<topic>"

### `quality-analysis-2.md` — Quality Analysis Report - Lang Module

# Quality Analysis Report - Lang Module
**Date**: 2025-11-11
**Analyst**: Claude Code
**Tools**: PHPStan Level 10, PHPInsights, PHPMD

---

## Executive Summary

The Lang module has been analyzed using three quality assurance tools:
- **PHPStan Level 10**: ✅ **PASS** (1 error fixed)
- **PHPInsights**: 79/100 Code quality
- **PHPMD**: Multiple design and complexity issues identified

## PHPStan Level 10 Analysis

### Status: ✅ PASSED

### Issues Fixed


### `quality-report-2.md` — Quality Report — Lang


# Quality Report — Lang

Aggiornato: 2026-08-24. Rigenera con: `bashscripts/tools/quality-report.sh Lang`

| Metrica | Valore |
|---|---|
| File PHP (app/) | 62 |
| LOC app/ | 4552 |
| File test | 25 |
| LOC test | 4700 |
| Test/App LOC ratio | 103.3% |
| PHPStan (level max) |  |

## Come misurare la coverage Pest

```bash
cd laravel
XDEBUG_MODE=coverage php -d memory_limit=2G ./vendor/bin/pest Modules/Lang/tests \
  --coverage-text --colors=never

### `redundancy-audit-2.md` — Lang redundancy audit 2026-05-21


# Lang redundancy audit 2026-05-21

Static metrics: 1816 files scanned, 25 case-only groups, 294 duplicate hash groups, 0 duplicate FQCN.

Findings:
- Heavy docs duplication: locale management, quick reference, translation strategies/process, implementation guide, and archive/historical copies.
- `docs/archive` and `docs/translations/archive` duplicate active translation docs.
- Migration directory case-only duplicate: `database/Migrations` vs `database/migrations`.
- Docs index variants include `index-3.md`/`index.md` and `00-INDEX.md`/`00-index.md`.

- Docs index variants include `index.md`/`index.md` and `00-index.md`/`00-index.md`.

Risk:
- Lang is foundational; stale translation rules can propagate wrong patterns across modules.
- Migration case-only duplicate is high-risk for autolo

### `rinvex-countries-usage-2.md` — Rinvex Countries Usage in Lang Module

# Rinvex Countries Usage in Lang Module

## Overview

The Lang module utilizes the [Rinvex Countries](https://github.com/rinvex/countries) package to provide comprehensive country data including names, ISO codes, flags, currencies, and geographical information. This package provides data for all 250+ countries worldwide.

## Installation

The package is installed via Composer:

```bash
composer require rinvex/countries
```

## Basic Usage

### Getting Single Country

```php
// Get single country by ISO alpha-2 code

### `risoluzione-permessi-lang-service-2.md` — Troubleshooting definitivo permessi file_put_contents su lang_service.php

# Troubleshooting definitivo permessi file_put_contents su lang_service.php

## Sintesi della soluzione robusta

1. **Ownership ricorsivo**
   - Tutti i file e le sottodirectory di `Modules/Lang/lang` devono essere di proprietà `www-data:www-data`.
   - Comando:
     ```bash
     sudo chown -R www-data:www-data /var/www/html/ptvx/laravel/Modules/Lang/lang
     ```
2. **Permessi sicuri e coerenti**
   - Tutte le directory: `ug+rwx,o+rx` (775)
   - Tutti i file: `ug+rw,o+r-w` (664)
   - Comando:
     ```bash
     sudo find /var/www/html/ptvx/laravel/Modules/Lang/lang -type d -exec chmod 775 {} +
     sudo find /var/www/html/ptvx/laravel/Modules/Lang/lang -type f -exec chmod 664 {} +
     ```
3. **Motivazione**
   - Garantisce che Apache/PHP (utente www-data) possa sempre leggere/scrivere fil

### `sprint-planning-2.md` — Lang Module - Sprint Planning

# Lang Module - Sprint Planning

**Module:** Lang  
**Sprint:** Sprint 1 (March 12-25, 2026)  
**Version:** 1.0.0

---

## Sprint Goal

Implement core internationalization system with multi-language support.

**Success Criteria:**
- ✅ Translation system working
- ✅ Language detection functional
- ✅ English and Spanish translations
- ✅ Fallback handling
- ✅ Test coverage >80%

---

### `static-text-translation-2.md` — Traduzione di Testi Statici in Laravel

# Traduzione di Testi Statici in Laravel

## Introduzione

La traduzione di testi statici in Laravel può essere gestita utilizzando due approcci principali: file PHP e file JSON. Questa documentazione, basata sul corso di Laravel Daily, analizza entrambi i metodi, evidenziando vantaggi e svantaggi, e propone un'implementazione per il progetto `saluteora`.

## Opzioni di Archiviazione delle Traduzioni

### File PHP

I file PHP sono stati il metodo predefinito per lungo tempo. Le traduzioni sono organizzate in file separati per lingua e funzionalità.

**Esempio**:
In un file Blade come `/var/www/html/saluteora/laravel/resources/views/auth/register.blade.php`, potremmo avere:
```php
<!-- Nome -->
<div>
    <x-input-label for="name" :value="__('auth.register.name')" />
    <x-text-input id="na

### `struttura-traduzioni-2.md` — Struttura corretta per i file di traduzione nel modulo Lang

# Struttura corretta per i file di traduzione nel modulo Lang

## Percorsi standard per i file di traduzione

I file di traduzione nel modulo Lang devono seguire una struttura precisa dei percorsi per evitare duplicazioni e conflitti:

```
/Modules/Lang/lang/{locale}/{file}.php
```

### Percorsi corretti
- ✅ `/Modules/Lang/lang/it/lang_service.php`
- ✅ `/Modules/Lang/lang/en/lang_service.php`

### Percorsi errati da evitare
- ❌ `/Modules/Lang/lang/lang/it/lang_service.php` (doppia cartella `lang`)
- ❌ `/Modules/Lang/resources/lang/it/lang_service.php` (percorso obsoleto)

## Anti-pattern comuni da evitare


### `tech-spec-2.md` — Technical Specification - Lang Module

# Technical Specification - Lang Module

## Overview
Detailed technical implementation for the Lang module, covering models, actions, Filament resources, and integration touchpoints.

## Models

### Core Models
### `BaseModelLang`$
### `LanguageLine`$
### `Translation`$

Each model extends `XotBaseModel` and follows Laraxot conventions:
- UUID primary key
- Timestamps (created_at, updated_at)
- Soft deletes where applicable
- Cast attributes for JSON fields

## Actions


### `traduzioni-navigation-2.md` — Traduzioni con ".navigation" - Audit Completo 2025

# Traduzioni con ".navigation" - Audit Completo 2025

## Riepilogo Problema
Molte traduzioni utilizzano ancora il pattern `.navigation` invece di traduzioni appropriate. Questo causa problemi di coerenza e manutenibilità.

## File Identificati con Problemi

### 1. Modules/User/lang/it/permission.php ✅ CORRETTO
**Stato**: File già corretto - non contiene traduzioni `.navigation`

### 2. Modules/Lang/lang/en/edit_translation_file.php ✅ CORRETTO
**Problema**: Multiple traduzioni con pattern `.navigation`
**Soluzione**: Sostituite tutte le traduzioni `.navigation` con traduzioni appropriate in inglese

**Traduzioni corrette implementate**:
- `content.navigation.name` → `Navigation Name`
- `content.navigation.plural` → `Navigation Plural`
- `content.navigation.group.name` → `Group Name`
- `cont

### `traduzioni-navigation-3.md` — Traduzioni con ".navigation" - Audit Completo 2025

# Traduzioni con ".navigation" - Audit Completo 2025

## Riepilogo Problema
Molte traduzioni utilizzano ancora il pattern `.navigation` invece di traduzioni appropriate. Questo causa problemi di coerenza e manutenibilità.

## File Identificati con Problemi

### 1. Modules/User/lang/it/permission.php ✅ CORRETTO
**Stato**: File già corretto - non contiene traduzioni `.navigation`

### 2. Modules/Lang/lang/en/edit_translation_file.php ✅ CORRETTO
**Problema**: Multiple traduzioni con pattern `.navigation`
**Soluzione**: Sostituite tutte le traduzioni `.navigation` con traduzioni appropriate in inglese

**Traduzioni corrette implementate**:
- `content.navigation.name` → `Navigation Name`
- `content.navigation.plural` → `Navigation Plural`
- `content.navigation.group.name` → `Group Name`
- `cont

### `translating-plural-singular-forms-2.md` — Traduzione di Forme Plurali e Singolari

# Traduzione di Forme Plurali e Singolari

## Introduzione

In un'applicazione multilingue, è comune dover gestire traduzioni che cambiano in base al conteggio di elementi (singolare/plurale). Laravel offre strumenti come `trans_choice()` per semplificare questo processo. Questa documentazione, basata sul corso di Laravel Daily, esplora come implementare la pluralizzazione nel progetto `saluteora`, sia nei file JSON che PHP, e come utilizzare la direttiva `@choice` nelle viste Blade.

## Uso di `trans_choice()` per Pluralizzazione

Laravel fornisce la funzione helper `trans_choice()` che permette di scegliere la traduzione corretta in base a un numero passato come parametro. Le regole per definire le traduzioni plurali sono:
- Usare il carattere `|` per separare le diverse opzioni di conte

### `translating-validation-messages-2.md` — Traduzione dei Messaggi di Validazione

# Traduzione dei Messaggi di Validazione

## Introduzione

In Laravel, i messaggi di validazione predefiniti sono generalmente adeguati, ma spesso è necessario personalizzarli per adattarli ai nomi dei campi visualizzati nell'interfaccia utente o per migliorare la chiarezza per gli utenti finali. Questa documentazione, basata sul corso di Laravel Daily, esplora come personalizzare i messaggi di validazione per il progetto `saluteora`, utilizzando metodi come `attributes()` e `messages()` nelle classi di richiesta form, e come tradurre questi messaggi per supportare più lingue.

## Problema di Corrispondenza tra Etichetta e Nome del Campo

Quando il nome di un campo nel form non corrisponde all'etichetta mostrata nell'interfaccia utente, i messaggi di validazione possono risultare poco intu

### `translation-completeness-audit-2.md` — Translation Completeness Audit

# Translation Completeness Audit

## Overview
This document tracks the completeness and quality of translation files across the <main module> system, ensuring all user-facing text is properly localized in Italian, English, and German.

## Recent Updates

### 2025-01-06: Complete PDF Template Internationalization

**Issue**: PDF template `/var/www/html/_bases/<directory progetto>/laravel/Themes/One/resources/views/appointment/report_pdf.blade.php` contained hardcoded Italian text, making it non-multilingual.

**Files Updated**:
- `laravel/Themes/One/resources/views/appointment/report_pdf.blade.php` (completely internationalized)
- `laravel/Themes/One/lang/it/appointment.php` (added PDF-specific translations)
- `laravel/Themes/One/lang/en/appointment.php` (added PDF-specific translations)
- 

### `translation-files-update-2.md` — Aggiornamento File di Traduzione - Gennaio 2025

# Aggiornamento File di Traduzione - Gennaio 2025

## Data Aggiornamento
2025-01-27

## File Modificati

### 1. `Modules/Notify/lang/it/test_smtp.php`
### 2. `Modules/Notify/lang/it/send_email.php`
### 3. `Modules/Lang/lang/it/lang_service.php`

## Modifiche Apportate

### 1. Sintassi Array Moderna
- **Prima**: Utilizzo di `array()` syntax
- **Dopo**: Utilizzo di sintassi array breve `[]`
- **Motivazione**: Conformità alle best practice Laraxot e PSR-12

### 2. Dichiarazione Strict Types
- **Aggiunto**: `declare(strict_types=1);` all'inizio di tutti i file

### `translation-files-update-3.md` — Aggiornamento File di Traduzione - Gennaio 2025

# Aggiornamento File di Traduzione - Gennaio 2025

## Data Aggiornamento
2025-01-27

## File Modificati

### 1. `Modules/Notify/lang/it/test_smtp.php`
### 2. `Modules/Notify/lang/it/send_email.php`
### 3. `Modules/Lang/lang/it/lang_service.php`

## Modifiche Apportate

### 1. Sintassi Array Moderna
- **Prima**: Utilizzo di `array()` syntax
- **Dopo**: Utilizzo di sintassi array breve `[]`
- **Motivazione**: Conformità alle best practice Laraxot e PSR-12

### 2. Dichiarazione Strict Types
- **Aggiunto**: `declare(strict_types=1);` all'inizio di tutti i file

### `translation-keys-best-practices-2.md` — Best Practices per le Chiavi di Traduzione

# Best Practices per le Chiavi di Traduzione

## Collegamenti correlati
- [README modulo Lang](./README.md)
- [Convenzioni Path](./PATH_CONVENTIONS.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)
- [Implementazione Header](/laravel/Modules/User/docs/header-language-avatar-implementation-4.md)

## Panoramica

Questo documento descrive le best practices per l'utilizzo delle chiavi di traduzione , con particolare attenzione alla struttura delle chiavi e all'evitare l'uso di stringhe in italiano come chiavi di traduzione.

## Regola Fondamentale: Mai Usare Chiavi in Italiano

### Problema

Un errore comune è utilizzare stringhe in italiano come chiavi di traduzione:

```php
// ERRATO

### `translation-keys-rules-2.md` — Regole per le Chiavi di Traduzione

# Regole per le Chiavi di Traduzione 

## Collegamenti correlati
- [Documentazione centrale](./README.md)
- [Collegamenti documentazione](./collegamenti-documentazione.md)
- [Implementazione Auth Pages](auth-pages-implementation-3.md)
- [Regole Traduzioni User](translation-keys-rules-3.md)
- [Documentazione Lang](./README.md)

## Regole Fondamentali per le Traduzioni

### 1. Struttura delle Chiavi di Traduzione

Le chiavi di traduzione  devono seguire una struttura gerarchica espansa:

```php
// Corretto
'auth' => [
    'login' => [
        'button' => [

### `translation-management-packages-2.md` — Translation Management Packages

# Translation Management Packages

## Overview
Managing translations effectively is vital for a healthcare application like `saluteora` to ensure accurate communication with users across different languages. This document explores various Laravel packages for translation management, helping choose the right tools for our needs.

## Evaluated Packages

### 1. Spatie Laravel Translation Loader
- **Purpose**: Allows storing translations in a database instead of language files.
- **Key Features**:
  - Database-driven translations
  - Fallback to language files if database entry doesn't exist
  - Custom driver support (e.g., CSV)
- **Use Case**: Ideal for building custom translation editor UI for administrative users.
- **Implementation**:
  ```bash
  composer require spatie/laravel-translation

### `translation-notify-conversion-2.md` — Standardizzazione Traduzioni Modulo Notify

# Standardizzazione Traduzioni Modulo Notify

## Panoramica delle Problematiche

Durante l'analisi del codice è emerso che numerosi file di traduzione nel modulo Notify non rispettano gli standard definiti per <main module>. Questo documento riassume i problemi identificati e le strategie di correzione implementate.

## Standard Violati

1. **Naming dei File**
   - Alcuni file utilizzano convenzioni di naming non conformi
   - Esempio: `send_whats_app.php` invece di `send_whatsapp.php`
   - Regola: i termini composti come "WhatsApp" devono essere trattati come un'unica parola in snake_case

2. **Struttura dei File**
   - Numerosi file mancano della dichiarazione `declare(strict_types=1);`
   - Manca spesso la sezione `resource` obbligatoria
   - Le strutture gerarchiche sono incomplete ris

### `translation-refactor-complete-summary-2.md` — Refactor Completo File di Traduzione - Riepilogo Finale

# Refactor Completo File di Traduzione - Riepilogo Finale

## Panoramica del Progetto
Refactor sistematico di tutti i file di traduzione non italiani contenenti le parole chiave "Città", "Provincia", "Regione", e "Accedi" per implementare una struttura standardizzata a 7 elementi e correggere le traduzioni errate.

## Obiettivi Raggiunti

### ✅ Struttura Standardizzata Implementata
Tutti i campi di traduzione ora includono la struttura completa a 7 elementi:
1. **label** - Etichetta del campo
2. **placeholder** - Testo di esempio
3. **tooltip** - Suggerimento breve
4. **helper_text** - Testo di aiuto dettagliato
5. **description** - Descrizione completa del campo
6. **icon** - Icona Heroicons appropriata
7. **color** - Colore del contesto

### ✅ Campi Geografici Standardizzati

#### Campo 

### `translation-standards-2.md` — Standard per le Traduzioni nel Progetto SaluteOra

# Standard per le Traduzioni nel Progetto SaluteOra

## Struttura delle Cartelle

Le traduzioni vanno posizionate nella cartella `lang` di ogni modulo, organizzate per lingua:

```
Modules/
  ├── ModuleName/
  │   └── lang/
  │       ├── it/
  │       │   ├── resource-name.php
  │       │   └── ...
  │       └── en/
  │           ├── resource-name.php
  │           └── ...
```

## Convenzione di Naming


### `translation-standards-links-2.md` — Collegamenti alla Documentazione sugli Standard di Traduzione

# Collegamenti alla Documentazione sugli Standard di Traduzione

## Problemi Identificati e Correzioni in Corso

Stiamo standardizzando i file di traduzione nel modulo Notify che presentano problemi di conformità con le convenzioni di <nome progetto>. Questo documento fornisce collegamenti rapidi a tutta la documentazione pertinente.

## Documentazione nel Modulo Notify

- [Progresso della Standardizzazione](translation-standards-progress-2.md)
- [Regole di Naming per i File di Traduzione](translation-file-naming-rules-2.md)
- [Guida alla Struttura dei File di Traduzione](translation-file-structure-guide-2.md)
- [Convenzioni di Traduzione nel Modulo Notify](translation-conventions-2.md)
- [Guida alla Correzione dei File di Traduzione](translation-file-correction-guide-2.md)

## Documentazi

### `translation-syntax-fixes-2.md` — Correzione Errori di Sintassi nei File di Traduzione

# Correzione Errori di Sintassi nei File di Traduzione

## Riepilogo Intervento

Sono stati identificati e risolti errori di sintassi PHP in 10 file di traduzione distribuiti su 6 moduli diversi. Tutti gli errori sono stati corretti seguendo le best practice Laraxot.

## Moduli Interessati

### Chart Module
- **File**: `laravel/Modules/Chart/lang/it/chart.php`
- **Errore**: Parentesi di chiusura mancante
- **Soluzione**: Aggiunta parentesi `]` finale

- **File**: `laravel/Modules/Chart/lang/it/mixed_chart.php`
- **Errore**: `declare(strict_types=1);` posizionato erroneamente
- **Soluzione**: Spostato dopo `<?php`

### FormBuilder Module
- **File**: `laravel/Modules/FormBuilder/lang/it/collection_lang.php`
- **Errore**: Parentesi di chiusura mancante

### `translation-system-2.md` — Sistema di Traduzione in il progetto

# Sistema di Traduzione in il progetto

## LangServiceProvider

Il `LangServiceProvider` è il cuore del sistema di traduzione e gestisce automaticamente le label dei componenti Filament.

### Funzionamento

1. **Caricamento Traduzioni**
   - Le traduzioni sono caricate dai file nella cartella `lang` di ogni modulo
   - Supporta sia file PHP che JSON
   - Usa il nome del modulo in minuscolo come namespace delle traduzioni

2. **Gestione Automatica Label**
   - Non si usa mai il metodo `->label()` direttamente sui componenti
   - Le label sono gestite automaticamente dal provider
   - Usa i file di traduzione per tutte le etichette

3. **Struttura File Traduzioni**
```php

### `translations-faq-2.md` — FAQ e Problemi Comuni sulle Traduzioni

# FAQ e Problemi Comuni sulle Traduzioni

## 1. Perché il POST non funziona su rotte localizzate?
Se non usi URL localizzati anche nei form/action, il middleware può fare redirect e cambiare il metodo in GET. Usa sempre gli helper per generare URL localizzati nei form.

## 2. Come si cache-izzano le rotte tradotte?
Usa il comando:
```bash
php artisan route:trans:cache
```
Non usare `route:cache` standard. Per Laravel 11+ segui la doc ufficiale per il caricamento delle rotte cache.

## 3. Cosa succede se una chiave manca?
Laravel mostra la chiave stessa. Se usi PHP e hai impostato fallback_locale, cerca nella lingua di fallback. Con JSON, mostra sempre la chiave.

## 4. Come gestire traduzioni per traduttori non-dev?
Preferisci JSON solo se necessario. Altrimenti, esporta le chiavi PHP in f

### `translations-storage-2.md` — Storage delle Traduzioni: PHP vs JSON

# Storage delle Traduzioni: PHP vs JSON

## Introduzione
In Laravel puoi salvare le traduzioni in file PHP strutturati o in file JSON flat. Ogni approccio ha vantaggi, svantaggi e impatti diversi su fallback, gestione team e manutenzione.

## Confronto tra PHP e JSON

| Caratteristica         | PHP Files                        | JSON Files                      |
|-----------------------|----------------------------------|---------------------------------|
| **Struttura**         | Annidata, multi-livello          | Flat, chiave = frase            |
| **Contesto**          | Sì (chiavi strutturate)          | No (tutto in un file)           |
| **Commenti**          | Sì                               | No                              |
| **Fallback**          | Sì (usa fallback_locale)     

### `user-link-2.md` — Collegamenti al Modulo User

# Collegamenti al Modulo User

Questo documento fornisce collegamenti bidirezionali tra il modulo Lang e il modulo User.

## Traduzioni nel Modulo User

Il modulo User utilizza le traduzioni fornite dal modulo Lang per:

- Etichette dei campi utente
- Messaggi di validazione
- Notifiche e messaggi di sistema
- Interfaccia di autenticazione

## Collegamenti Principali

- [Traduzioni del Modulo User](../../User/docs/translations.md) - Documentazione specifica sulle traduzioni nel modulo User
- [Gestione Utenti](../../User/docs/README.md) - Panoramica del modulo User
- [Modelli Utente](../../User/docs/user_profile_models.md) - Documentazione sui modelli utente e profili

## Integrazione con Lang

### `user-research-2.md` — Lang Module - User Research

# Lang Module - User Research

**Module:** Lang  
**Version:** 1.0.0  
**Last Updated:** March 12, 2026  
**Owner:** Product Team

---

## Research Goals

1. Understand language preferences
2. Identify translation quality expectations
3. Validate language switching UX
4. Determine regional variations

---

## Research Questions


### `validation-messages-2.md` — Gestione delle Traduzioni dei Messaggi di Validazione

# Gestione delle Traduzioni dei Messaggi di Validazione

## Obiettivo
Fornire una guida completa per:
- Tradurre i messaggi di validazione standard e personalizzati
- Gestire la corrispondenza tra label e nome campo nei messaggi di errore
- Gestire array di campi e placeholder dinamici
- Scrivere messaggi di validazione user-friendly e localizzati

---

## 1. Messaggi di Validazione Standard

Laravel fornisce messaggi di default in `resources/lang/{lang}/validation.php`.  
**Consiglio:**  
- Usa il pacchetto [Laravel-Lang/lang](https://github.com/Laravel-Lang/lang) per avere traduzioni aggiornate e complete.
- Aggiorna i file con `composer require laravel-lang/common --dev` e `php artisan lang:add it`.

---


### `validation-translations-2.md` — Traduzione dei Messaggi di Validazione

# Traduzione dei Messaggi di Validazione

## Indice
1. [Introduzione](#introduzione)
2. [Traduzione degli Attributi](#traduzione-degli-attributi)
3. [Validazione di Campi Array](#validazione-di-campi-array)
4. [Messaggi Personalizzati](#messaggi-personalizzati)
5. [Implementazione nel Progetto](#implementazione-nel-progetto)
6. [Best Practice](#best-practice)
7. [Risoluzione Problemi](#risoluzione-problemi)

## Introduzione

Questo documento descrive come gestire le traduzioni dei messaggi di validazione in Laravel, con particolare attenzione alla personalizzazione e all'internazionalizzazione.

## Traduzione degli Attributi

### Il Problema di Base

Di default, Laravel genera messaggi di validazione come:

### `volt-integration-2.md` — Integrazione di mcamara/laravel-localization con Laravel Volt

# Integrazione di mcamara/laravel-localization con Laravel Volt

## Indice
1. [Introduzione](#introduzione)
2. [Configurazione Iniziale](#configurazione-iniziale)
   - [Installazione di Volt](#installazione-di-volt)
   - [Configurazione di Laravel-Localization](#configurazione-di-laravel-localization)
3. [Middleware per Volt](#middleware-per-volt)
4. [Componenti Volt Localizzati](#componenti-volt-localizzati)
5. [Gestione dei Form](#gestione-dei-form)
6. [Testing](#testing)
7. [Best Practice](#best-practice)
8. [Risoluzione Problemi](#risoluzione-problemi)

## Introduzione

L'integrazione di `mcamara/laravel-localization` con Laravel Volt richiede un approccio specifico per garantire che i componenti reattivi rispettino l'impostazione della lingua corrente. Questa guida ti mostrerà come im

### `volt-localization-integration-2.md` — Integrazione Livewire Volt + mcamara/laravel-localization

# Integrazione Livewire Volt + mcamara/laravel-localization

## 1. Obiettivo

- Gestire componenti Livewire Volt in un'applicazione Laravel multilingua con route localizzate tramite mcamara/laravel-localization.
- Permettere la localizzazione delle route che montano componenti Volt.
- Gestire la lingua corrente all'interno dei componenti Volt (sia per visualizzazione che per azioni dinamiche).

---

## 2. Setup di base

### 2.1. Installazione pacchetti

```bash
composer require livewire/volt
composer require mcamara/laravel-localization
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
```


### `wiki/integrations/_da-riconciliare/documentation-link-conventions-2.md` — Convenzioni per i Link nella Documentazione

# Convenzioni per i Link nella Documentazione

## Regole Fondamentali per i Link Markdown

### 1. Utilizzare Sempre Percorsi Relativi

I collegamenti nei file di documentazione devono **sempre** utilizzare percorsi relativi, mai percorsi assoluti.

✅ **CORRETTO**:
```markdown
[Regole Generali](../../Xot/docs/translations.md)
[Best Practices](../../../translation-keys-best-practices-3.md)
```

❌ **ERRATO**:
```markdown
[Regole Generali](/var/www/html/<directory progetto>/laravel/Modules/Xot/docs/translations.md)
[Best Practices](/var/www/html/<directory progetto>/laravel/Modules/Lang/docs/translation-keys-best-practices-2.md)
```


### `wiki/integrations/_da-riconciliare/enum-translation-pattern-implementation-2.md` — Enum Translation Pattern - Implementazione Regola Critica


# Enum Translation Pattern - Implementazione Regola Critica

## Data: 27 Gennaio 2025

## Panoramica del Lavoro

Ho implementato e documentato la regola critica per le traduzioni degli enum usando `transClass()`, creando un sistema completo di regole, memorie e documentazione per garantire la conformità del progetto.

## Regola Critica Implementata

### ⚠️ REGOLA ASSOLUTA PER ENUM ⚠️

**SEMPRE** usare `transClass()` negli enum per le traduzioni. MAI usare `__()` o `trans()` direttamente.

### Pattern Corretto
```php
use Modules\Xot\Filament\Traits\TransTrait;

enum MyEnum: string implements HasColor, HasIcon, HasLabel

### `wiki/integrations/_da-riconciliare/mcamara-implementation-guide-2.md` — Guida all'Implementazione di mcamara/laravel-localization


# Guida all'Implementazione di mcamara/laravel-localization

## Indice
1. [Panoramica](#panoramica)
2. [Installazione](#installazione)
3. [Configurazione](#configurazione)
4. [Gestione delle Route](#gestione-delle-route)
5. [Interruttore di Lingua](#interruttore-di-lingua)
6. [Traduzione delle Route](#traduzione-delle-route)
7. [Gestione della Cache](#gestione-della-cache)
8. [Risoluzione dei Problemi](#risoluzione-dei-problemi)
9. [Best Practice](#best-practice)

## Panoramica

Il pacchetto `mcamara/laravel-localization` fornisce un sistema completo per la gestione della localizzazione in Laravel, con particolare attenzione alla traduzione delle route e alla gestione delle lingue.

## Installazione


### `wiki/integrations/_da-riconciliare/performance-optimization-2.md` — Performance Optimization — Module **Lang**


# Performance Optimization — Module **Lang**

## Ottimizzazioni Applicate

### 1. On-Demand Loading (principale)

**Prima**: Bootstrap caricava tutte le rules (50K+ token)
**Dopo**: Carico solo what's needed (~2K startup)

\`\`\`diff
- 150+ rules embeddate in agents-3.md
+ 0 rules embeddate — tutte on-demand
\`\`\`

### 2. Cache Esterna al Repo

\`\`\`diff
- .cache/ (8KB nel repo)
+ ~/.cache/qmd-cache/ (fuori da git)

### `wiki/integrations/_da-riconciliare/phpstan-fixes.divergenza.md` — Divergenza: `phpstan-fixes-2.md`


# Divergenza: `phpstan-fixes-2.md`

Questo file veniva da `phpstan-fixes-2.md`, cancellato dal working tree senza migrazione. Il modulo ha gia' un file con lo stesso nome, ma con **corpo diverso**:

- versione del modulo: `laravel/Modules/Lang/docs/phpstan-fixes.md`
- versione recuperata: `laravel/Modules/Lang/docs/wiki/integrations/_da-riconciliare/phpstan-fixes.md`

Vanno confrontate e fuse a mano. Quando la fusione e' fatta, questo file e la nota vanno rimossi.

Vedi [XOT-5.39](../../../stories/5.39.wiki-integrations-ownership.story.md).

### `wiki/integrations/_da-riconciliare/pluralization-and-localization-2.md` — Plurale/Singolare e Localizzazione Date/Valute

# Plurale/Singolare e Localizzazione Date/Valute

## Pluralizzazione

### Uso di `trans_choice()` e `@choice()`
- Per messaggi che variano in base al conteggio, usa `trans_choice()` o la direttiva Blade `@choice()`.
- Sintassi tipica in PHP:
  ```php
  // lang/en/messages.php
  return [
      'newMessageIndicator' => '{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages',
  ];
  ```
- In Blade:
  ```blade
  @choice('messages.newMessageIndicator', $messagesCount)
  ```
- Sintassi delle regole plurali:
  - `{0}`: caso zero
  - `{1}`: caso singolare

### `wiki/integrations/_da-riconciliare/quality-improvements-2.md` — Miglioramenti Qualità Codice - Modulo Lang - 2025-01-06


# Miglioramenti Qualità Codice - Modulo Lang - 2025-01-06

## Data
2025-01-06

## Obiettivo
Migliorare la qualità del codice del modulo Lang utilizzando PHPStan livello 10, PHPMD, PHPInsights e Rector.

## Analisi Iniziale

### PHPStan Livello 10
**Status**: ⏳ In corso

### PHPMD
**Problemi Identificati**:

#### ConvertTranslations.php
- **StaticAccess**: Uso eccessivo di accesso statico a `Assert` e `File` (20+ occorrenze)
- **ShortVariable**: Variabile `$to` con nome troppo corto

### `wiki/integrations/_da-riconciliare/translation-refactor-complete-summary-2.md` — Refactor Completo File di Traduzione - Riepilogo Finale


# Refactor Completo File di Traduzione - Riepilogo Finale

## Panoramica del Progetto
Refactor sistematico di tutti i file di traduzione non italiani contenenti le parole chiave "Città", "Provincia", "Regione", e "Accedi" per implementare una struttura standardizzata a 7 elementi e correggere le traduzioni errate.

## Obiettivi Raggiunti

### ✅ Struttura Standardizzata Implementata
Tutti i campi di traduzione ora includono la struttura completa a 7 elementi:
1. **label** - Etichetta del campo
2. **placeholder** - Testo di esempio
3. **tooltip** - Suggerimento breve
4. **helper_text** - Testo di aiuto dettagliato
5. **description** - Descrizione completa del campo
6. **icon** - Icona Heroicons appropriata
7. **color** - Colore del contesto

### ✅ Campi Geografici Standardizzati


### `wiki/integrations/_da-riconciliare/translation-strategies-2.md` — Strategie di Gestione delle Traduzioni in Laravel


# Strategie di Gestione delle Traduzioni in Laravel

## Indice
1. [Panoramica](#panoramica)
2. [File PHP vs JSON](#file-php-vs-json)
3. [Struttura delle Cartelle](#struttura-delle-cartelle)
4. [Helper di Traduzione](#helper-di-traduzione)
5. [Best Practice](#best-practice)
6. [Implementazione nel Progetto](#implementazione-nel-progetto)
7. [Migrazione tra Formati](#migrazione-tra-formati)
8. [Processo Dev → Traduttore: Strategia Operativa](#processo-dev-→-traduttore-strategia-operativa)
9. [Gestione Plurale/Singolare nelle Traduzioni](#gestione-plurale-singolare-nelle-traduzioni)

## Panoramica

In Laravel, esistono due approcci principali per gestire le traduzioni:
- **File PHP**: tradizionale, con struttura ad array
- **File JSON**: più moderno, con chiavi testuali


### `working-with-locales-2.md` — Gestione delle Lingue (Locales) in Laravel

# Gestione delle Lingue (Locales) in Laravel

## Introduzione

In Laravel, la gestione delle lingue (locales) è fondamentale per determinare quale lingua utilizzare per le traduzioni. Ogni progetto Laravel ha una lingua predefinita e una di fallback. Questa documentazione, basata sul corso di Laravel Daily, esplora come configurare queste impostazioni e propone modifiche per il progetto `saluteora`.

## Configurazione della Lingua Predefinita

Per impostare la lingua predefinita dell'applicazione, modificare il file `config/app.php`:

```php
'locale' => 'it',
// Deve corrispondere al nome della cartella in `lang/FOLDER` o al nome del file `lang/KEY.json`.
```

Questa sarà la lingua predefinita per tutti gli utenti dell'applicazione. È importante non lasciare il valore predefinito 'en' se l
