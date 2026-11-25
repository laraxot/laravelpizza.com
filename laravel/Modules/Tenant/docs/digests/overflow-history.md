---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 251 file oltre target 100.

### `_integration/tenant.md` — tenant

# tenant

<!-- Contenuto migrato da _docs/tenant.txt -->

https://gist.github.com/nathandaly/44a83df5e3ea735eae91652c7a4894c9

### `agent-confidence-discipline.md` — Disciplina agenti per massimizzare la confidenza


# Disciplina agenti per massimizzare la confidenza

Regola canonica: [../../Xot/docs/wiki/concepts/agent-confidence-discipline.md](../../Xot/docs/wiki/concepts/agent-confidence-discipline.md).

Sintesi: verificare prima di affermare; riprodurre prima di correggere; documentare prove, dubbi e rischio residuo; rispondere in italiano sintetico.

### `agent-confidence-protocol.md` — Massima confidenza agente


# Massima confidenza agente

Stub DRY. Regola canonica: [../../../../docs/wiki/rules/agent-confidence-protocol.md](../../../../docs/wiki/rules/agent-confidence-protocol.md).

Checklist locale: issue GitHub, wiki owner, file letti a chunk, gate eseguiti, log aggiornato, limiti dichiarati.

### `agent-edit-discipline.md` — Disciplina edit e qualità (puntatore)


# Disciplina edit e qualità (puntatore)

Stub **DRY**: policy nella wiki di progetto; discussione e ragionamenti in GitHub issue [#124](https://github.com/provtv/base_ptv_fila5/issues/124).

## Link operativi (relativi al repo)

- Regola canonica: [../../../../docs/wiki/rules/validation-post-edit-rule.md](../../../../docs/wiki/rules/validation-post-edit-rule.md)
- How-to issue ↔ wiki: [../../../../bashscripts/ai/wiki/how-to/git-github.md#github-issue-agent-discipline](../../../../bashscripts/ai/wiki/how-to/git-github.md#github-issue-agent-discipline)
- Prompt LLM: [../../../../bashscripts/tools/prompts/llm-wiki.txt](../../../../bashscripts/tools/prompts/llm-wiki.txt) §3 (FLVP)

## Perché questo file

Chi lavora solo nel subtree del modulo/tema trova subito la policy globale senza copiare 

### `ai-methodologies.md` — AI Methodologies Handbook

# AI Methodologies Handbook

This file is a DRY local index for AI workflows in this module or theme.

## Canonical Sources

- [OpenViking Integration Guide](../../../../docs/openviking-integration.md)
- [AI Methodologies Integration](../../../../bashscripts/ai/wiki/memories/agent-conduct-tooling.md#ai-methodologies-integration)
- [Root Docs Index](../../../../docs/index.md)

## Local Workflow

1. Read the local docs index before changing anything in this module or theme.
2. Update the relevant local docs file.
3. Update the local docs index (`README.md`, `index.md`, or `00-index.md`).
4. Only then index the docs folder with OpenViking.
5. Use BMAD for requirements, GSD for execution, and Ralph Loop for longer autonomous iterations.

## OpenViking Rule


### `alternatives.md` — alternatives

https://github.com/InterNACHI/modular

### `api-integration.md` — api-integration



### `api.md` — API Reference: Tenant Module


# API Reference: Tenant Module

## Overview

This document describes all public APIs, contracts, and services exposed by the Tenant module for managing multi-tenancy, tenant context, and configuration.

## Public Contracts

### `TenantContract`
**Location:** `app/Contracts/TenantContract.php`

```php
interface TenantContract {
    public function getId(): int|string;
    public function getName(): string;
    public function getSlug(): string;
    public function getDomain(): ?string;
    public function getDatabaseName(): ?string;
    public function isActive(): bool;

### `architecture-rules.md` — Architectural Rules & Guidelines

# Architectural Rules & Guidelines

This module adheres to the **Laraxot Architecture** and **Super Cow Methodology**.

For strict coding standards, Filament extension rules, and PHPStan guidelines, please refer to the central documentation in the **Xot Module**:

-   [Super Cow Methodology](../../xot/docs/super_cow_methodology.md)
-   [PHP Quality Guide](../../xot/docs/php_quality_guide.md)
-   [Filament Extension Rules](../../xot/docs/filament-extension-rules-2.md)

**Key Principles:**
1.  **DRY & KISS**: Don't repeat yourself, keep it simple.
2.  **Zero Errors**: PHPStan Level 10 compliance is mandatory.
3.  **XotBase**: Always extend `XotBase` classes, never Filament classes directly.
4.  **Translations**: Use `LangServiceProvider` for automatic label resolution.

### `arr-first-vs-collect-first-decision.md` — Decisione: Arr::first() vs collect()->first()

# Decisione: Arr::first() vs collect()->first()

**Data**: 2025-01-22
**Metodologia**: Super Mucca - La Litigata Interna
**File**: `app/Actions/Config/GetTenantConfigValueAction.php`

---

## 🧠 La Litigata Interna

### Contesto
L'utente chiede: "Al posto di `$group = collect(explode('.', $key))->first();` non potevi utilizzare `Arr::first()`?"

### Le Voci in Dibattito

#### 🗣️ Voce A - Pragmatica (Mantieni Collection)
> "Collection è già usata nel progetto, è consistente. Lasciamo così."

**Argomenti a favore**:
- ✅ Consistente con resto del codice

### `arr-first-vs-collect-first-ision.md` — Decisione: Arr::first() vs collect()->first()

# Decisione: Arr::first() vs collect()->first()

**Metodologia**: Super Mucca - La Litigata Interna
**File**: `app/Actions/Config/GetTenantConfigValueAction.php`

---

## 🧠 La Litigata Interna

### Contesto
L'utente chiede: "Al posto di `$group = collect(explode('.', $key))->first();` non potevi utilizzare `Arr::first()`?"

### Le Voci in Dibattito

#### 🗣️ Voce A - Pragmatica (Mantieni Collection)
> "Collection è già usata nel progetto, è consistente. Lasciamo così."

**Argomenti a favore**:
- ✅ Consistente con resto del codice
- ✅ Collection offre più metodi utili

### `audit-models-migrations.md` — Tenant Module Models & Migrations Audit


# Tenant Module Models & Migrations Audit

## Executive Summary

**Finding:** Tenant module has 9 models but 0 migrations.

**Status:** Intentional architectural pattern (not a bug).

**Risk Level:** Low — tables managed via dynamic connection configuration.

---

## Inventory

### Models (9 total)

| Model | Type | Connection | Table Needed |
|-------|------|-----------|--------------|
| Tenant | Eloquent | tenant | tenants |

### `best-practices.md` — best-practices



### `binary-assets.md` — Asset binari


# Asset binari

Gli asset binari sono file normali del repository.

Regole:
- non aggiungere filtri o backend di storage esterno in `.gitattributes`;
- non committare file pointer al posto del contenuto reale;
- se un asset manca, recuperare il binario originale e committarlo direttamente;
- prima del push verificare che immagini, font, archivi e PDF siano contenuti reali.

### `bmad/agent-edit-discipline.md` — Disciplina edit e qualità (puntatore)

tags: [docs, tenant, bmad]

# Disciplina edit e qualità (puntatore)

Stub **DRY**: policy nella wiki di progetto; discussione e ragionamenti in GitHub issue [#124](https://github.com/provtv/base_ptv_fila5/issues/124).

## Link operativi (relativi al repo)

- Regola canonica: [../../../../docs/wiki/rules/validation-post-edit-rule.md](../../../../docs/wiki/rules/validation-post-edit-rule.md)
- How-to issue ↔ wiki: [../../../../../bashscripts/ai/wiki/how-to/git-github.md#github-issue-agent-discipline](../../../../../bashscripts/ai/wiki/how-to/git-github.md#github-issue-agent-discipline)
- Prompt LLM: [../../../../bashscripts/tools/prompts/llm-wiki.txt](../../../../bashscripts/tools/prompts/llm-wiki.txt) §3 (FLVP)

## Perché questo file

Chi lavora solo nel subtree del modulo/tema trova subito

### `bmad/ai-methodologies.md` — AI Methodologies Handbook

# AI Methodologies Handbook

This file is a DRY local index for AI workflows in this module or theme.

## Canonical Sources

- [OpenViking Integration Guide](../../../../docs/openviking-integration.md)
- [AI Methodologies Integration](../../../../../bashscripts/ai/wiki/memories/agent-conduct-tooling.md#ai-methodologies-integration)
- [Root Docs Index](../../../../docs/index.md)

## Local Workflow

1. Read the local docs index before changing anything in this module or theme.
2. Update the relevant local docs file.
3. Update the local docs index (`README.md`, `index.md`, or `00-index.md`).
4. Only then index the docs folder with OpenViking.
5. Use BMAD for requirements, GSD for execution, and Ralph Loop for longer autonomous iterations.

## OpenViking Rule


### `bmad/alternatives.md` — alternatives

https://github.com/InterNACHI/modular

### `bmad/api-integration.md` — api-integration



### `bmad/architecture/module-boundary.md` — Tenant — architettura

tags: [docs, tenant, bmad]
# Tenant — architettura

## Scopo osservato

Multi-tenancy e contesto organizzativo. Scheda derivata da `module.json`, struttura `app/` e conteggi del repository; non sostituisce decisioni architetturali non ancora approvate.

## Inventario verificato

- PHP in `app/`: 53 file.
- Test PHP in `tests/`: 50 file.
- Aree applicative: `Enums`, `Http`, `Filament`, `Services`, `Contracts`, `Models`, `Console`, `Actions`, `Providers`, `View`.
- Persistenza: `database/factories`, `database/migrations`, `database/seeders` presenti.

## Confini

Il modulo espone risorse, azioni e contratti verso i consumatori; la logica di dominio deve restare nelle Action e nei modelli del modulo. Le dipendenze verso Xot, User, Tenant e UI vanno verificate tramite namespace/import reali pr

### `bmad/audit-models-migrations.md` — Tenant Module Models & Migrations Audit

tags: [docs, tenant, bmad]

# Tenant Module Models & Migrations Audit

## Executive Summary

**Finding:** Tenant module has 9 models but 0 migrations.

**Status:** Intentional architectural pattern (not a bug).

**Risk Level:** Low — tables managed via dynamic connection configuration.

---

## Inventory

### Models (9 total)

| Model | Type | Connection | Table Needed |
|-------|------|-----------|--------------|

### `bmad/audit.md` — Audit BMAD — Tenant


# Audit BMAD — Tenant

SSoT dettagliata: [audits/tenant-audit.md](./audits/tenant-audit.md). Questo file è solo la sintesi.

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
| PHP `app/` | 56 |
| Test | 65 |
| Resources | 1 |
| Actions | 19 |
| Services | 0 |
| Policy `return true` | 2 |
| Marker | 0 |

## Lo scopo in una frase **Tenant permette a una sola installazione di servire piu' enti senza che nessuno veda i dati dell'altro, e di farlo cambiando configurazione invece che codice.**

## Gate

### `bmad/audits/tenant-audit.md` — Audit approfondito — Tenant


# Audit approfondito — Tenant

## Metodo

Source-first (2026-11-16): inventario filesystem, `rg` su policy/marker/label,
lettura purpose esistente, PHPStan globale Modules già a 0 errori. Nessuna UI
inventata. Pest dichiarato solo se eseguito.

## Inventario misurato

| Area | Conteggio |
|---|---:|
| PHP in `app/` | 56 |
| Test PHP | 65 |
| Models (`app/Models/*.php`) | 10 |
| Policy files (approx) | 4 |
| Resource Filament | 1 |
| Actions | 19 |
| Services | 0 |

### `bmad/best-practices.md` — best-practices



### `bmad/bmad-dossier.md` — Tenant — BMAD dossier

# Tenant — BMAD dossier
## Product brief / PRD
Isolate municipality identity, content, policies and provider configuration.
## Architecture / UX / security
Tenant context is resolved before domain/content actions and cannot be inferred from user-controlled data.
## Epics and stories
Resolution; configuration lifecycle; isolation/audit.
## Gaps / release
Candidate domain matrix, cache/session isolation, missing-tenant behavior and config promotion need proof.

### `bmad/brainstorming/module-opportunities.md` — Tenant — brainstorming

tags: [docs, tenant, bmad]
# Tenant — brainstorming

## Punto di partenza

Multi-tenancy e contesto organizzativo. L'inventario corrente misura 53 file applicativi e 50 file di test.

## Domande ad alto valore

- Quale problema utente risolve il modulo e quale comportamento è vincolante?
- Quali dati sono autorevoli e quali sono proiezioni o cache?
- Quali ruoli possono leggere, creare, modificare o approvare?
- Quale errore deve essere osservabile senza esporre dati sensibili?
- Quale parte è riusabile e quale è specifica del dominio PTVX?

## Ipotesi da validare

- Le Action sono il punto di orchestrazione del caso d'uso.
- Le Resource Filament sono adattatori, non il luogo della regola di business.
- I test esistenti sono evidenza parziale e vanno confrontati con i flussi esposti.

### `bmad/brainstorming.md` — Tenant — Brainstorming


# Tenant — Brainstorming

> **SUMMARY** — Decisioni prese, questioni aperte e opzioni scartate del modulo `Tenant`,
> ancorate a file e simboli reali. Il brainstorming di dettaglio per area è negli shard.
> ancorate a file e simboli reali (riverificate il 2026-11-16: le voci su
> `ConfigResolverRegistry`, `StandardConfigResolver` e `TenantService` erano obsolete e
> sono state rimosse — `app/Services` non esiste, la logica è in Action).
=======
> ancorate a file e simboli reali (riverificate il 2026-11-16: le voci su
> `ConfigResolverRegistry`, `StandardConfigResolver` e `TenantService` erano obsolete e
> sono state rimosse — `app/Services` non esiste, la logica è in Action).
> Il brainstorming di dettaglio per area è negli shard.

## Shard

| Shard | Path |
|-------|------|
| Opportunita

### `bmad/changelog-root.md` — Changelog

# Changelog

All notable changes to `:package_name` will be documented in this file.

## 1.0.0 - 202X-XX-XX

- initial release

### `bmad/confidence-guidelines.md` — Massimizzare il livello di confidenza

# Massimizzare il livello di confidenza

1. **Test automatizzati**: copertura >90%, includi test unitari, integrazione, e fine‑to‑end.
2. **CI/CD**: esegui tutti i test su ogni commit, blocca merge se falliscono.
3. **Analisi statica**: PHPStan, Psalm e Laravel Pint al livello massimo.
4. **Revisione del codice**: code‑review obbligatoria con checklist di qualità.
5. **Monitoraggio in produzione**: New Relic / Sentry per errori e performance.
6. **Documentazione**: mantieni aggiornati doc e changelog.
7. **Rollback rapido**: feature flags e versioni per tornare indietro.

### `bmad/coverage.md` — Tenant Module Test Coverage

# Tenant Module Test Coverage

## Overview
This module has comprehensive test coverage with various test types implemented.

## Test Results
- **Tests Passed**: 0
- **Assertions**: 0
- **Test Types**: Unit, Feature, Integration tests

## Coverage Statistics
## Status

**2026-09-06**: ../philosophy-2.md created. PHPStan analyzed (OK). Pest suite (TBD). Coverage target: +5% per module.

### 2026-09-06 (sessione claude sonnet 5 — `phpstan-tenant-fix.md`)

PHPStan `Modules/Tenant` con cache pulita: **0 errori** prima e dopo le modifiche (nessuna
regressione introdotta). Dettaglio completo delle modifiche in
`docs/stories/phpstan-tenant-fix.md`: rimossi 7 docblock `@property-read User|null

### `bmad/decision-log.md` — Decision log — Tenant


# Decision log — Tenant

Verificate sul codice il 2026-11-16. Finding: [audits/tenant-audit.md](./audits/tenant-audit.md).

| ID | Decisione | Stato | Perché | Evidenza |
|---|---|---|---|---|
| D-01 | Il tenant si riconosce dall'host (`SERVER_NAME`, poi `getHost()`), con fallback al default | Attiva, da rivedere (TEN-P1-01) | strategia meno invasiva; ma l'host è input del client | [GetTenantNameAction.php](../../app/Actions/GetTenantNameAction.php) |
| D-02 | La config per ente vive in `config/<tenant>/` e si legge via Action | Attiva | cambiare ente = cambiare configurazione, non codice | [GetTenantConfigPathAction.php](../../app/Actions/Config/GetTenantConfigPathAction.php) |
| D-03 | I percorsi per-tenant passano da `GetTenantFilePathAction`, mai da `base_path()`; rifiuta assoluti, `\

### `bmad/epics/module-roadmap.md` — Tenant — epic roadmap

tags: [docs, tenant, bmad]
# Tenant — epic roadmap

## Epic A — Contratto e architettura

Documentare API pubbliche, dipendenze, confini e invarianti del modulo.

## Epic B — Qualità verificabile

Ridurre finding PHPStan, mantenere test Pest eseguibili e registrare evidence ripetibile.

## Epic C — UX e integrazione

Verificare parità Form/Table, traduzioni, autorizzazioni, error handling e integrazioni dichiarate.

## Epic D — Documentazione viva

Collegare ogni decisione a story BMAD, mantenere il second brain e chiudere i duplicati senza cancellare storia.

## Definition of Done

### `bmad/epics.md` — Epics — Tenant


# Epics — Tenant

Origine: [audits/tenant-audit.md](./audits/tenant-audit.md). Epic storici: [epics/tenant-config-resolution.md](./epics/tenant-config-resolution.md), [epics/module-roadmap.md](./epics/module-roadmap.md). Story di coordinamento: [0005-module-bmad-audit.story.md](stories/0005-module-bmad-audit.story.md).

Ordine di valore: prima l'isolamento fra enti (A), poi chi amministra (B), poi i segreti (C).

## Epic A — Host fidato (TEN-P1-01)

**Perché:** il tenant deriva dall'host; un `Host:` forgiato su un vhost catch-all seleziona la config di un altro ente.

- Task: attivare `TrustHosts` (pattern dai domini in `config/<tenant>/`) oppure documentare e verificare il vhost/`server_name` esplicito.
- AC: un host non elencato non seleziona un tenant diverso dal default; test su `GetT

### `bmad/livewire-inventory.md` — Inventario: Livewire HTTP → Filament — modulo Tenant


# Inventario: Livewire HTTP → Filament — modulo Tenant

**Solo documentazione. Nessun PHP toccato in questo audit.**

Questo file è la SSoT del modulo Tenant per la campagna di conversione Livewire → Filament widget. Formato e metodo ripresi da [Modules/Cms/docs/bmad/livewire-inventory.md](livewire-inventory.md).

## Metodo (codice, non assunzione)

```bash
find Modules/Tenant/app/Http/Livewire Modules/Tenant/app/Livewire -type f -name '*.php'
find Modules/Tenant -iname '*livewire*' -not -path '*/vendor/*'
find Modules/Tenant -path '*/vendor/*' -prune -o -name '*.php' -print | xargs grep -l 'extends.*\(Component\|Livewire\)'
grep -rn "@livewire" Modules/Tenant/resources/views
grep -rln "<livewire:" Modules/Tenant/resources/views
find Modules/Tenant/app/Filament/Widgets -type f
ls Modules/

### `bmad/piano-miglioramento.md` — Piano di miglioramento — Tenant


# Piano di miglioramento — Tenant

Derivato dall'[audit](./audits/tenant-audit.md).

## P0

1. Bonificare marker/conflict se presenti (ora: 0).
2. Chiudere policy troppo permissive (`return true` ≈ 2) con matrice ruolo×ability.
3. Blocchi sicurezza runtime (auth panel, mass assignment, export) con test negativi.

## P1

1. Portare Services (0) ad Actions Queueable dove applicabile.
2. Alzare copertura test (attuale 65 test / 56 app PHP).
3. Allineare Filament (resources=1) a XotBase* e traduzioni Lang.
4. Spezzare dipendenze inverse verso verticali peer se rilevate con `rg`.

## P2


### `bmad/purpose.md` — Tenant — perche' esiste


# Tenant — perche' esiste

## Lo scopo in una frase

**Tenant permette a una sola installazione di servire piu' enti senza che nessuno veda
i dati dell'altro, e di farlo cambiando configurazione invece che codice.**

## L'evidenza

- `Domain`, `TenantDomain` — il tenant si riconosce **dall'URL**: e' la strategia meno
  invasiva e la meno fragile.
- `TenantSetting` — cio' che varia fra enti e' un dato.
- `DatabaseConfig` — isolamento che puo' arrivare fino a basi dati separate.
- `TenantSubscription` — un tenant ha un ciclo di vita.
- `BaseModelJsons`, `TestSushiModel` — configurazione da file JSON letta come se fosse
  una tabella (Sushi).
- Solo 56 file PHP: **la potenza sta nella posizione, non nel volume**. E' attraversato
  da ogni richiesta.


### `bmad/quick-reference.md` — Tenant — Quick Reference


# Tenant — Quick Reference

> **SUMMARY** — Riferimento rapido del modulo `Tenant`: dove sta cosa, quali classi usare,
> quali test guardare. Paths relativi a `laravel/Modules/Tenant`.

## Punti di ingresso

| Cosa | Path |
|------|------|
| Facade di dominio | `app/Services/TenantService.php` |
| Bootstrap | `app/Providers/TenantServiceProvider.php` |
| Config statica del modulo | `config/config.php` |
| Config DB | `config/database.php` |
| Moduli abilitati | `config/modules.php` |

## Azioni per uso frequente

| Azione | Path |
|--------|------|

### `bmad/setup-guide.md` — Tenant — Setup Guide


# Tenant — Setup Guide

> **SUMMARY** — Come si porta il modulo `Tenant` in un ambiente funzionante: config da
  caricare, provider da registrare, migrazioni presenti nel modulo, test da eseguire.
> Comandi da eseguire dalla root di `laravel/`.

## 1. Registrazione provider

`module.json` e `composer.json` dichiarano:

- `Modules\Tenant\Providers\TenantServiceProvider`
- `Modules\Tenant\Providers\Filament\AdminPanelProvider`

`app/Providers/TenantServiceProvider.php::register()` ha la registrazione di
`AdminPanelProvider` commentata: il pannello Filament del modulo non viene registrato
automaticamente, va verificato chi lo registra.

## 2. Config


### `bmad/status.md` — Tenant — BMAD Status


# Tenant — BMAD Status
- PHPStan: 0 errori
- Inventario docs/: bmad/ molto esteso; wiki/ duplicati maiuscole
- Wiki: docs/wiki/module-purpose.md creato

### `bmad/stories/0002-continuazione-domani.story.md` — Continuazione domani

# Continuazione domani

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0003-docs-reorg-core.story.md` — Story — riorganizzazione docs core: Tenant

# Story — riorganizzazione docs core: Tenant

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0004-docs-zen-conventions.story.md` — Tenant — bonifica docs `.md`

# Tenant — bonifica docs `.md`

## Context and Problem Statement

Lane C dello swarm `laravel/Modules/Xot/docs/bmad/stories/docs-zen-conventions-swarm.story.md`: nomi e
frontmatter erano gia' a norma, restava rumore da template generici e 4 file senza `qmd`.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

### `bmad/stories/0006-module-bmad-baseline-audit.story.md` — Story — Tenant: baseline BMAD

# Story — Tenant: baseline BMAD

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0007-phpstan-modules-zero.story.md` — Story: PHPStan zero — Tenant

# Story: PHPStan zero — Tenant

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/continuazione-domani.md` — Tenant — Continuazione Domani

# Tenant — Continuazione Domani

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/sushi-model-pitfalls.md` — Sushi nei modelli Tenant: trappole verificate

tags: [docs, tenant, bmad]

# Sushi nei modelli Tenant: trappole verificate

Sintomi visti sul campo, causa verificata sul codice, cura. Story: `stories/7.4.sushi-connection-by-name.story.md`.

## 1. `unique` / `exists` rispondono "no such table"

Sintomo: `SQLSTATE[HY000]: General error: 1 no such table: web_services (Connection: Modules\Sigma\Models\WebService, Database: :memory:, ...)`
su `select count(*) ... where "name" = ...` durante la validazione di un form Filament con `->unique()`.

Causa:

- `Sushi::getConnectionName()` restituisce `static::class` (`vendor/calebporzio/sushi/src/Sushi.php:276`).
- `Rule::unique(Model::class)` risolve il nome connessione dal modello (`DatabaseRule::resolveTableName`, `Illuminate/Validation/Rules/DatabaseRule.php:61`)
  e `DatabaseManager::connecti

### `bugfix-larastan-tenant-model-collision.md` — Bugfix: PHPStan `assign.propertyType` — TenantFactory duplicata confonde il tipo Tenant


# Bugfix: PHPStan `assign.propertyType` — TenantFactory duplicata confonde il tipo Tenant

## 🐛 Errore

**Data:** 2026-07-17
**Comando:** `./vendor/bin/phpstan analyse Modules` (root, `laravel/phpstan.neon`, invariata)

**File:** `Modules/Tenant/tests/Integration/Traits/SushiToJsonTraitIntegrationTest.php:23,325`

```
Property Modules\Tenant\Tests\TestCase::$tenant (Modules\Tenant\Models\Tenant|null)
does not accept Modules\User\Models\Tenant.
```

### Causa

Esistono **due classi factory distinte** con lo stesso nome breve `TenantFactory`,
per due modelli "Tenant" diversi:


### `business-logic-deep-dive.md` — Tenant Module - Business Logic Deep Dive

# Tenant Module - Business Logic Deep Dive

## 🎯 Module Overview

Il modulo Tenant è il **foundation layer per il multi-tenancy** dell'intera applicazione. Gestisce l'isolamento dati, la configurazione distribuita e l'identificazione automatica del tenant senza inquinare la business logic dei moduli dipendenti.

---

## 🏗️ Core Architecture

### Tenant Identification Layer
```
Request → Domain/URL Analysis → Tenant Identification → Connection Setup → Business Logic
    ↓
GetTenantNameAction
    ↓
$_SERVER['SERVER_NAME'] parsing
    ↓
Tenant-specific DB connection
```

### `case-sensitivity-rules.md` — Case Sensitivity Rules - Tenant Module

# Case Sensitivity Rules - Tenant Module

## Problema / Problem

**NON possono esistere file con lo stesso nome che differiscono solo per maiuscole/minuscole nella stessa directory.**

Riferimento completo: [Xot Module Case Sensitivity Rules](../../xot/docs/case-sensitivity-rules.md)

## File/Directory Rimossi da Tenant Module

I seguenti file/directory sono stati eliminati perché violavano le regole:

### Directory Structure
```
✗ Removed: database/Factories/ (entire directory)
✗ Removed: database/Factories_/ (stale underscore copy)
✓ Kept:    database/factories/

✗ Removed: Tests/ (entire directory)
✓ Kept:    tests/

### `case-variant-collisions.md` — Collisioni di nome per sola differenza di maiuscole


# Collisioni di nome per sola differenza di maiuscole

**Misurato**: 2026-08-31
**Regola violata**: `no-case-variations`, `case_sensitive_naming_critical`
**Quadro generale**: [Modules/Xot/docs/stato-qualita-progetto-2026-08-31.md](../../Xot/docs/stato-qualita-progetto.md)

## Il problema

In questo modulo esistono percorsi che differiscono solo per maiuscole. Su Linux
convivono. Su filesystem case-insensitive, cioe' macOS di default e Windows, i due
percorsi sono lo stesso percorso: al clone uno dei due file sovrascrive l'altro, in
modo non deterministico. Il repository risulta corrotto senza che nulla segnali
l'errore.

Riproduzione:

```bash
cd laravel && find Modules/Tenant -name '*.php' -not -path '*/vendor/*' \
  | awk '{print tolower($0)}' | sort | uniq -d

### `chaos-monkey-tenant-isolation-checklist.md` — Chaos Monkey Tenant Isolation Checklist (Tenant)

# Chaos Monkey Tenant Isolation Checklist (Tenant)

## Obiettivo
Mantenere isolamento tenant e coerenza connessioni DB sotto fault injection.

## Invarianti Critiche
1. Config tenant locale contiene solo `mysql`, `user`, `sqlite` (opzionale).
2. Connessioni modulo registrate dinamicamente da `TenantServiceProvider`.
3. `.env.testing` replica `.env`, cambiando solo nomi database con suffix `_test`.
4. Nessuna duplicazione config connessioni in TestCase/setUp().

## Checklist Incident
1. Verificare tenant risolto correttamente da host/context.
2. Verificare che la connessione attiva non punti al DB sbagliato.
3. Verificare mappatura test connection per moduli.
4. Verificare assenza di connessioni modulo hardcoded nei tenant config.
5. Eseguire test isolamento dati su due tenant distinti.

##

### `code-quality-improvement-report.md` — Code Quality Improvement Report — Tenant


# Code Quality Improvement Report — Tenant

> Baseline statica riproducibile per orientare il miglioramento. I conteggi sono segnali, non sostituiscono PHPStan, Pest o la review del flusso reale.

## GitHub (repo del modulo)

```bash
cd laravel/Modules/Tenant && git remote -v
# laraxot → git@github.com:laraxot/module_tenant_fila5.git
```

**Lezione grave:** in un conflitto Git, *entrambe* le parti possono essere sbagliate. Qui HEAD puntava a `<nome repository>` — nessuno dei due è il remote Tenant. Non scegliere a caso: scoprire il remote nella cartella del modulo.

## Baseline

| Indicatore | Valore |
|---|---:|
| File PHP applicativi/database/route | 69 |
| File di test PHP | 34 |

### `code-quality-report.md` — Code quality — modulo Tenant


# Code quality — modulo Tenant

Report locale (2026-07-17). Metodo: `phpstan analyse` livello max, `phpmd` (ruleset codesize+unusedcode), grep mirati (TODO/FIXME/@deprecated, dd()/dump(), facade in app/Actions, extends Filament diretto), rapporto file test/app.

## Numeri

- File in `app/`: 45
- File di test: 34 — rapporto test/app: 75%
- File con TODO/FIXME/@deprecated: 0
- PHPStan: 0 errori (livello max, sweep repo-wide 2026-07-16/17)
- Violazioni PHPMD (codesize+unusedcode): 19
- File in `app/Actions/` che importano Facade Laravel direttamente (violazione pattern QueueableAction, vedi skill `queueable-action-trait`): 6

### File con Facade in Actions da convertire

- Modules/Tenant/app/Actions/Translations/TranslateTenantKeyAction.php
- Modules/Tenant/app/Actions/Modules/GetTenantModul

### `code-redundancy-audit.md` — Code redundancy audit — Tenant


# Code redundancy audit — Tenant

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo module, senza perdere conoscenza storica.

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 77 |
| Rischio ridondanza | high |
| Basename duplicati locali | 5 |
| Hash normalizzati duplicati cross-owner | 2 |
| Class/trait/interface name ripetuti nel monorepo | 12 |
| File grandi >=350 righe | 1 |
| File PHP con marker Git | 0 |

## Evidenze

### `codex-error-fix.md` — Codex Configuration Error Fixes

# Codex Configuration Error Fixes

Questo documento descrive le correzioni applicate agli errori riscontrati durante l'avvio di `codex`.

## 1. Errori YAML negli SKILL.md

### Sintomo
`invalid YAML: mapping values are not allowed in this context` o `invalid YAML: name: invalid type: map`.

### Causa
Caratteri speciali come `:` o `{}` all'interno di valori non racchiusi tra virgolette nel frontmatter YAML.

### Soluzione
Racchiudere sempre i valori di `name` e `description` tra virgolette doppie nel frontmatter.

**Esempio Errato:**
```yaml
---
name: { my-skill-name }
description: Rule: always do X.

### `concepts/tenant-service-to-actions-migration.md` — TenantService → Actions


# TenantService → Actions

## Cosa è successo

`app/Services/TenantService.php` (facade statica 1:1) è stato **eliminato**. I caller usano le Actions già presenti in `app/Actions/`.

## Mappa sostituzioni

| Vecchio | Nuovo |
|---------|-------|
| `TenantService::getConfig($name)` | `app(GetTenantConfigArrayAction::class)->execute($name)` |
| `TenantService::saveConfig($name, $data)` | `app(SaveTenantConfigAction::class)->execute($name, $data)` |
| `TenantService::trans($key)` | `app(TranslateTenantKeyAction::class)->execute($key)` |
| `TenantService::allModules()` | `app(GetTenantModulesAction::class)->execute()` |
| `TenantService::config($key)` | `app(GetTenantConfigValueAction::class)->execute($key)` |
| `TenantService::getName()` | `app(GetTenantNameAction::class)->execute()` |
| `Te

### `concepts/xotbase-never-extend-filament.md` — Mai `Filament\*` — sempre `Modules\Xot\Filament\...\XotBase*`


# Mai `Filament\*` — sempre `Modules\Xot\Filament\...\XotBase*`

Bridge on-demand. Contenuto canonico: [docs/wiki/rules/xotbase-critical-rules.md](../../../../docs/wiki/rules/xotbase-critical-rules.md).

## Zen (riassunto)

Nessuna classe in `Modules/Tenant` estende una classe `Filament\...` direttamente.
Si estende sempre lo "specchio" in `Modules\Xot\Filament\...` allo stesso
percorso relativo (es. `Filament\Tables\Columns\ViewColumn` ->
`Modules\Xot\Filament\Tables\Columns\XotBaseViewColumn`). Se manca il
mirror, va creato in Xot prima di usarlo qui, mai come scorciatoia nel modulo.

Non pre-caricare questo file: leggi la fonte canonica solo quando il task lo richiede.

### `configuration-logic-analysis.md` — Configuration System Architecture - Tenant Module

# Configuration System Architecture - Tenant Module

## Data: [DATE]
## Metodologia: Super Mucca - La Litigata Interna
## File: `Modules/Tenant/app/Services/TenantService.php` e `app/Actions/Config/GetTenantFilePathAction.php`

---

## 🧠 La Litigata Interna

### Contesto
Il sistema di configurazione multi-tenant utilizza percorsi specifici per ogni tenant. L'utente ha identificato che i file di configurazione non sono nella directory sbagliata (`config/<nome progetto>.local/`) ma nella directory corretta (`config/local/<nome progetto>/`).

### Le Voci in Dibattito

#### 🗣️ Voce A - Pragmatica (Accettare il sistema esistente)
> "Il sistema funziona già. Non serve capire il perché, basta usarlo come è stato progettato."

**Argomenti a favore**:
- ✅ I percorsi esistono e funzionano

### `configuration.md` — Tenant Module Configuration Reference


# Tenant Module Configuration Reference

## Overview

The Tenant module configuration is split across three files:
1. **config/config.php** — Module meta, navigation, features
2. **config/database.php** — Database strategy and connection management
3. **config/metatag.php** — Per-tenant meta tag configuration

All values can be overridden at runtime via `TenantSetting` model.

---

## config/config.php

Module-level configuration for routing, navigation, and features.

### Module Metadata


### `conflict-resolution.md` — Conflict Resolution — Module Tenant

# Conflict Resolution — Module Tenant

## Summary
- **Files resolved**: 2
- **Strategy**: Keep HEAD/local (ours) side
- **Root cause**: Nested stash-on-merge conflicts

## PHP Files
- app/Providers/TenantServiceProvider.php

## Documentation Files
- docs/nestedset-migration-best-practices.md

## Backlinks
- [Root conflict resolution report](../../../../docs/conflict-resolution-report.md)

### `conflict-resolutiones.md` — Risoluzione Conflitti Git - Modulo Tenant

# Risoluzione Conflitti Git - Modulo Tenant

## Panoramica
Documentazione della risoluzione dei conflitti Git nel modulo Tenant che bloccavano l'analisi PHPStan.

## File Interessati

### 1. app/Services/TenantService.php
**Problema**: Marker di conflitto causavano ParseError
**Risoluzione**: Selezione della "current change" per tutti i conflitti

**Conflitti risolti**:
- Controlli `is_array()` con spaziatura corretta
- Gestione eccezioni `throw new Exception`
- Chiamate `str_replace()` con parametri corretti
- Controlli `isset()` con sintassi corretta
- Signature del metodo `modelClass()` con tipizzazione corretta


## Metodologia di Risoluzione

### `conflicts.md` — conflicts



### `contracts/create-json-file-by-record-action.md` — CreateJsonFileByRecordAction


# CreateJsonFileByRecordAction

Sorgente: `app/Actions/Json/CreateJsonFileByRecordAction.php`. Gemelle: `UpdateJsonFileByRecordAction`,
`DeleteJsonFileByRecordAction` (stessa chiave `($keyName, $key)`).

## Input

- `Model&HasSushiToJson $record`: il record da aggiungere, non ancora salvato.

## Output

- `void`; il record riceve `id`, `created_at`, `updated_at`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-JSON-CREATE-INV-1 | Nuovo id = max(id numerici esistenti) + 1; gli id stringa numerici (`"11"`) valgono come interi, quelli non numerici come 0. | `TENANT-JSON-CREATE-INV-1` |
| TENANT-JSON-CREATE-INV-2 | File senza righe = id 1, nessuna `ValueError` da `max()`. | `TENANT-JSON-CREATE-INV-2` |

### `contracts/delete-json-file-by-record-action.md` — DeleteJsonFileByRecordAction


# DeleteJsonFileByRecordAction

Rimuove dal file JSON del tenant la riga del record cancellato. Codice: `app/Actions/Json/DeleteJsonFileByRecordAction.php:22-52`.

## Input

- `Model&HasSushiToJson $record`: record con chiave.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `DELETE-JSON-INV-1` | La chiave deve essere un intero o una stringa di sole cifre; altrimenti `Assert` lancia. Questo esclude le chiavi UUID, che `UpdateJsonFileByRecordAction` accetta: incoerenza tra le due Action. | riga 34 | nessuno |
| `DELETE-JSON-INV-2` | La riga con quella chiave è rimossa e il file è riscritto come lista. | righe 38-50 | nessuno |
| `DELETE-JSON-INV-3` | Se la chiave non esiste, il file è riscritto invariato. | righe 40-50 | nessuno 

### `contracts/filter-config-string-keys-action.md` — FilterConfigStringKeysAction


# FilterConfigStringKeysAction

Tiene solo le voci con chiave stringa di un array di configurazione. Codice: `app/Actions/Config/FilterConfigStringKeysAction.php:9-30`.

## Input

- `array<mixed, mixed> $config`: array con chiavi di qualunque tipo (riga 17).

## Output

- `array<string, mixed>`: stesse voci di `$config` con chiave stringa, nello stesso ordine (righe 19-28).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-FILTER-INV-1` | Il risultato contiene solo chiavi stringa; le chiavi intere sono scartate. | righe 22-25 | `tests/Unit/TenantGapsCoverageTest.php` (riferimento alla classe, non per l'invariante) |
| `TENANT-FILTER-INV-2` | Il filtro è solo di primo livello: le chiavi intere annidate restano. | righe 22-25 (nessuna ricorsione

### `contracts/get-domains-array-action.md` — GetDomainsArrayAction


# GetDomainsArrayAction

Ricostruisce i domini dei tenant dalla struttura delle cartelle sotto `config/`. Codice: `app/Actions/Domains/GetDomainsArrayAction.php:13-81`.

## Input

- Nessun parametro. Scansiona `config_path()`.

## Output

- `array<int, array{id: string, name: string}>`: per ogni cartella foglia (vuota), `id` e `name` sono il dominio ricostruito invertendo il percorso (`eu/fixcity` diventa `fixcity.eu`) (righe 26-33, 63-81).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-DOMAINS-INV-1` | Le cartelle chiamate `lang` sono escluse a ogni livello. | riga 50 | `tests/Unit/Actions/Domains/GetDomainsArrayActionTest.php` |
| `TENANT-DOMAINS-INV-2` | Solo le cartelle foglia (senza sottocartelle) producono un dominio. | righe 68-70 | 

### `contracts/get-ente-data-action.md` — GetEnteDataAction


# GetEnteDataAction

Legge i dati dell'ente da `config('ente')` e li restituisce normalizzati in un `EnteData`. Codice: `app/Actions/Ente/GetEnteDataAction.php:22-151`.

## Input

- `?string $locale`: lingua per i testi; se assente usa la lingua corrente dell'app (riga 44).

## Output

- `EnteData`: campi testuali, `pec`, `email`, `dpo_email`, `phone`, `toll_free`, `region_url` e `social` (lista di `{network, label, url, icon}`).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-ENTE-INV-1` | Un valore mancante o non valido vale stringa vuota, mai un segnaposto. | righe 46, 80-82 | `tests/Unit/Actions/Ente/GetEnteDataActionTest.php` |
| `TENANT-ENTE-INV-2` | Per i testi per lingua vale: lingua richiesta, poi `app.fallback_locale`, poi il primo

### `contracts/get-localized-markdown-path-action.md` — GetLocalizedMarkdownPathAction


# GetLocalizedMarkdownPathAction

Trova il file markdown del tenant nella lingua corrente, con ripiego sulla versione generica. Codice: `app/Actions/Markdown/GetLocalizedMarkdownPathAction.php:11-33`.

## Input

- `string $name`: percorso relativo del markdown (ad esempio `privacy.md`).

## Output

- `string`: percorso assoluto del primo file esistente, nell'ordine `lang/<locale>/<name>` poi `<name>`; `'#'` se nessuno esiste (righe 19-31).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-MD-INV-1` | Vince la versione nella lingua corrente, se esiste. | righe 19-25 | `tests/Unit/Actions/Markdown/GetLocalizedMarkdownPathActionTest.php` |
| `TENANT-MD-INV-2` | Se nessun file esiste, il risultato è `'#'`. | righe 27-29 | `tests/Unit/Actions/Markd

### `contracts/merge-recursive-string-key-config-action.md` — MergeRecursiveStringKeyConfigAction


# MergeRecursiveStringKeyConfigAction

Fonde più array di configurazione, scartando le chiavi non stringa. Codice: `app/Actions/Config/MergeRecursiveStringKeyConfigAction.php:9-37`.

## Input

- `array<array-key, mixed> ...$configs`: uno o più array; anche con chiavi intere (riga 20).

## Output

- `array<string, mixed>`: fusione ricorsiva; con zero argomenti restituisce `[]`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-MERGE-INV-1` | Il risultato ha solo chiavi stringa di primo livello. | righe 29 e 34 | `tests/Unit/TenantCoverageBoostTest.php` (riferimento alla classe) |
| `TENANT-MERGE-INV-2` | Con più array, vince l'ultimo per ogni chiave foglia (`array_replace_recursive`). | righe 27-30 | nessuno dedicato |


### `contracts/save-tenant-config-action.md` — SaveTenantConfigAction


# SaveTenantConfigAction

Persiste un file di configurazione del tenant corrente fondendo i dati nuovi con quelli esistenti. Codice: `app/Actions/Config/SaveTenantConfigAction.php:12-73`.

## Input

- `string $name`: nome del file di config senza estensione (diventa `<name>.php`).
- `array<string, mixed> $data`: chiavi da scrivere.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente (senza group) |
|---|---|---|---|
| `TENANT-SAVE-INV-1` | Il file è sempre risolto con `GetTenantFilePathAction` (stesso controllo anti-traversal e stesso isolamento per tenant). | riga 21 | `tests/Unit/Actions/Config/SaveTenantConfigActionTest.php` |
| `TENANT-SAVE-INV-2` | Le chiavi esistenti non presenti in `$data` sono conservate; gli array associativi si fondono ricorsi

### `contracts/translate-tenant-key-action.md` — TranslateTenantKeyAction


# TranslateTenantKeyAction

Traduce una chiave `file.chiave` usando il file di lingua del tenant. Codice: `app/Actions/Translations/TranslateTenantKeyAction.php:14-45`.

## Input

- `string $key`: il primo segmento (prima del punto) è il nome del file in `lang/<locale>/`; il resto è la chiave annidata (righe 22-27).

## Output

- `string`: la traduzione, oppure la chiave originale se non si risolve (righe 31, 41, 43).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-TRANS-INV-1` | Se il file di lingua del tenant non esiste, si restituisce la chiave. | righe 29-32 | `tests/Unit/Actions/Translations/TranslateTenantKeyActionTest.php` |
| `TENANT-TRANS-INV-2` | Se la chiave non è una stringa, si restituisce la chiave. | righe 39-41 | `tests/Unit/

### `contracts/update-json-file-by-record-action.md` — UpdateJsonFileByRecordAction


# UpdateJsonFileByRecordAction

Sostituisce nel file JSON del tenant la riga del record modificato. Codice: `app/Actions/Json/UpdateJsonFileByRecordAction.php:22-51`.

## Input

- `Model&HasSushiToJson $record`: record con chiave valorizzata.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `UPDATE-JSON-INV-1` | La riga è identificata da `($keyName, $key)` e sostituita. | righe 37-39 | `tests/Unit/Actions/Json/JsonFileByRecordActionsTest.php` |
| `UPDATE-JSON-INV-2` | La chiave può essere intera o stringa (UUID); bool e float sono rifiutati da `Assert::validArrayKey`. | riga 34 | nessuno dedicato |
| `UPDATE-JSON-INV-3` | Se la chiave non esiste nel file, la riga viene aggiunta (upsert). | riga 39 | nessuno (comportamento da con

### `contracts-naming.md` — Contracts Naming & Placement in Tenant


# Contracts Naming & Placement in Tenant

> A contract is an **agreement**, not a PHP keyword. We name it `*Contract` and place it under `app/Contracts/`.

## Rule

- ✅ `app/Contracts/ExampleContract.php`
- ❌ `app/Interfaces/ExampleInterface.php`

## Why

- `Contract` describes the domain concept (a pact between components).
- `interface` describes a PHP implementation detail.
- One folder (`app/Contracts/`) keeps the module language consistent and reduces cognitive noise.
- Aligned with Laravel `Illuminate\Contracts\*` convention.

## Verification

```bash

### `core-functionality.md` — core-functionality



### `cosa-migliorare.md` — Cosa migliorare — modulo Tenant


# Cosa migliorare — modulo Tenant

Ogni affermazione qui sotto viene da un comando eseguito il 1 settembre 2026, dopo il
ripristino di `vendor/` a 330 pacchetti. Le misure precedenti a quella data giravano su
un autoloader dimezzato e non valgono.

## I numeri

| | |
|---|---:|
| Errori PHPStan (modulo isolato) | 0 |
| Rilievi PHPMD su `app/` | 4 |
| PHPInsights — Code | 91.8 % |
| PHPInsights — Architecture | 85.7 % |
| PHPInsights — Style | 90.1 % |
| File PHP | 141 |
| Casi di test | 173 |
| Casi di test per file | 1.23 |
| Coverage di riga | **mai misurata** |

### `coverage.md` — Tenant Module Test Coverage

title: "Tenant Module Test Coverage"
module: "Tenant"
type: concept
tags: [coverage]
created: 2026-07-14
updated: 2026-09-07
qmd: "coverage"
related:
  - "./phpstan-corrections-january.md"
  - "./stories/phpstan-tenant-fix.md"
---
# Tenant Module Test Coverage

## Overview
This module has comprehensive test coverage with various test types implemented.

## Test Results
- **Tests Passed**: 0
- **Assertions**: 0
- **Test Types**: Unit, Feature, Integration tests

### `customizing-your-site.md` — customizing-your-site



### `cyclomatic-complexity-report.md` — Cyclomatic Complexity Report - Module: Tenant

# Cyclomatic Complexity Report - Module: Tenant

**Analyzer:** Super Mucca 🐮

---

## 📊 Summary Statistics

| Metric | Value |
|--------|-------|
| Total PHP Files | 78 |
| Total Lines of Code | 7525 |
| Total Classes/Traits/Interfaces | 68 |
| Total Methods | 288 |
| High Complexity Methods (>10) | 0 |

---

## 🎯 Cyclomatic Complexity Overview


### `data-models.md` — data-models



### `database-config-standard.md` — Database config standard (Laravel 13.x)

# Database config standard (Laravel 13.x)

**Status**: attivo  
**Riferimento**: https://github.com/laravel/laravel/blob/13.x/config/database.php

## Obiettivo

Il file `config/database.php` deve essere **identico** allo standard Laravel 13.x per garantire compatibilita' e manutenibilita'.

## Motivazione

### Perche' standard Laravel 13.x

1. **Gestione Dinamica Connessioni Modulari**
   - Le connessioni modulari vengono aggiunte **automaticamente** da `TenantServiceProvider::registerDB()`
   - Non serve hardcodare connessioni nel file principale
   - Il sistema gestisce tutto dinamicamente

2. **Compatibilità Aggiornamenti**
   - File standard = compatibilita' garantita con aggiornamenti Laravel

### `database-population.md` — Popolamento Database - Modulo Tenant

# Popolamento Database - Modulo Tenant

## Aggiornamento [DATE] – Test Sushi Seeder

- Rafforzata la type safety del seeder `TestSushiSeeder` utilizzando `Webmozart\Assert` per evitare errori PHPStan (`method.nonObject`) su `create()` e `count()`.
- Ogni invocazione di `TestSushiModel::factory()` viene validata con `Assert::isInstanceOf` prima di usare i metodi fluenti.
- Aggiunte annotazioni PHPDoc (`Factory<TestSushiModel>`) per rendere espliciti i tipi attesi al livello 10.
- Il seeding random per ambienti `local`/`testing` mantiene il comportamento originario, ma con assert espliciti.

### Motivazioni

- Previene factory "miste" quando il generatore viene sostituito o mockato.
- Allinea la strategia di seeding del modulo Tenant con il principio Laraxot “fix, don’t ignore”.
- Limita il 

### `database-structure-refactor.md` — Database Structure Refactor — Tenant Module


# Database Structure Refactor — Tenant Module

**Date**: 2026-07-01  
**Status**: ✅ COMPLETED

---

## Changes Made

### Deleted Folders (Violations)

| Folder | Reason | Date Deleted | Files |
|--------|--------|--------------|-------|
| `database/Factories/` | CamelCase violation | 2026-07-01 | 3 files (DomainFactory, TenantFactory, TestSushiModelFactory) |
| `database/Factories_/` | OLD with underscore, stale since 2025-12-23 | 2026-07-01 | 1 file (DomainFactory.php) |
| `database/Seeders/` | CamelCase violation | 2026-07-01 | 2 files (DomainsSeeder, TestSushiSeeder) |

### Canonical Folders (Kept)


### `database.md` — database



### `decision-log.md` — Decision Log — Tenant

# Decision Log — Tenant

## Decisions

### 2026-10-08: Riallineamento dell'intero modulo all'ultimo commit buono `90acbda`, piu' tre correzioni al trait SushiToJson
- **Choose**: Confronto a tre vie dell'intero modulo (app, config, routes, resources, lang, database, tests) con `90acbda` (07/10 06:40), l'ultimo commit prima del merge `2edad8e` (07/10 11:17) che ha ripreso una copia del 04/09.
- **Over**: Lasciare il trait `SushiToJson` alla copia del 04/09, o ripristinarlo da solo come stamattina (fallito: i test erano rimasti alla copia vecchia).
- **Because**: Con Xot riallineato le rotte dei moduli sono tornate e la dashboard ha cominciato a caricare modelli `BaseModelJson`: `Declaration of BaseModelJson::getSchema() must be compatible with HasSushiToJson::getSchema(): array`. Il trait d

### `dependencies.md` — dependencies



Installed packages index:

- [../../../../docs/packages/index.md](../../../../docs/packages/index.md)

### `dependency-intelligence.md` — Dependency Intelligence - Module Tenant

# Dependency Intelligence - Module Tenant


## Runtime dependencies (`require`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| _(none)_ | - | - | - |

## Dev dependencies (`require-dev`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| _(none)_ | - | - | - |

## Declared but missing from installed set

- Nessun pacchetto mancante nel lock corrente.

## Workspace critical runtime versions

### `docs-health.md` — Docs Health - Tenant

# Docs Health - Tenant

## Snapshot

- Scope directory: laravel/Modules/Tenant/docs
- Markdown files (top-level in this docs folder): 143
- Has canonical index 00-index.md: yes
- Has README.md: yes

## Confidence Checklist

- [ ] 00-index links only canonical docs (no obsolete duplicates)
- [ ] README and 00-index are coherent and do not diverge
- [ ] New docs use stable names (no dates in filename)
- [ ] Deprecated docs are explicitly marked and linked to canonical replacements
- [ ] Every technical decision has one canonical reference doc

## Canonical Rules

1. Read order: 00-index.md -> README.md -> focused docs.

### `dry-kiss-analysis.md` — DRY & KISS Analysis - Modulo Tenant

# DRY & KISS Analysis - Modulo Tenant

**Data:** 15 Ottobre 2025  
**DRY Score:** ✅ 94%  
**KISS Score:** ✅ 90%

## ✅ Stato Attuale

### BaseModel Buono
```php
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'tenant';
    
    protected function casts(): array {
        return array_merge(parent::casts(), [
            'verified_at' => 'datetime',
        ]);
    }
}

### `duplicate-files-to-remove.md` — File Duplicati da Eliminare - Modulo Tenant

# File Duplicati da Eliminare - Modulo Tenant

## 🗑️ File da Eliminare (Case Sensitivity)

```bash
# Elimina file lowercase (duplicato)
rm Modules/Tenant/tests/Unit/domaintest.php
```

## ✅ File da Mantenere

```bash
# Mantieni file UpperCamelCase (corretto PSR-4)
Modules/Tenant/tests/Unit/DomainTest.php
```

## 📜 Regola

**File PHP con classi DEVONO usare UpperCamelCase (PascalCase) identico al nome della classe (PSR-4).**


### `duplicate-methods-analysis.md` — Analisi Metodi Duplicati - Modulo Tenant

# Analisi Metodi Duplicati - Modulo Tenant

**Totale Gruppi di Duplicati**:

## Sommario Esecutivo

Questo documento identifica i metodi duplicati nel modulo **Tenant** che potrebbero beneficiare di refactoring.

### Statistiche

| Tipo Refactoring | Conteggio |
|------------------|----------:|
| **Trait** | 0 |
| **Base Class** | 0 |
| **Interface** | 7 |
| **Altro** | 1 |

## Dettaglio Metodi Duplicati

### 1. Metodo: `trans`

### `duplicate-methods.md` — Metodi duplicati — Tenant

# Metodi duplicati — Tenant

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **76**
- Metodi duplicati trovati: **26**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `execute` | 13 | candidato a trait/helper |
| `definition` | 11 | candidato a trait/helper |
| `active` | 6 | candidato a trait/helper |
| `casts` | 5 | candidato a trait/helper |
| `getJsonFile` | 5 | candidato a trait/helper |
| `run` | 5 | candidato a trait/helper |
| `canResolve` | 4 | candidato a trait/helper |
| `getRows` | 4 | candidato a trait/helper |
| `getSushiRows` | 4 | candidato a trait/helper |

### `en/tutorial-video.md` — tutorial-video

https://www.youtube.com/watch?v=_eyz7rvwLTQ

### `ente-data.md` — Dati dell'ente


# Dati dell'ente

- `Modules\Tenant\Actions\Ente\GetEnteDataAction` legge `config('ente')` (file `config/<tenant>/ente.php`) e restituisce un
  `Modules\Tenant\Datas\EnteData` normalizzato: valore mancante o non valido = stringa vuota, mai un segnaposto.
- Telefono: solo cifre con `+` iniziale, 3-15 cifre, dopo aver tolto spazi, punti, trattini, parentesi e barre.
- `EnteData::link()` costruisce `tel:` tenendo solo cifre e `+`.

## Pulizia con `Str::of()->replaceMatches()`

Le pulizie con regex (`GetEnteDataAction::text()`, `::phone()`, `EnteData::link()`) usano
`Str::of($value)->replaceMatches($pattern, '')`, non `Safe\preg_replace`: il risultato resta sempre una stringa
(niente `string|array`) e non serve l'import di `Safe`.

## Regressione del sync del 21/11 (24/11/2026)

Il sync dei m

### `event-sourcing.md` — event-sourcing



### `events.md` — events



### `exchanges.md` — exchanges



### `filament-resources.md` — filament-resources



### `filament-table-architecture.md` — La tabella si configura nella Table class, non nella pagina


# La tabella si configura nella Table class, non nella pagina

Vale per ogni Resource di questo modulo.

## La regola

Colonne, filtri e azioni di una Resource stanno in
`app/Filament/Resources/<Nome>Resource/Tables/<Plurale>Table.php`, che estende
`Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable`.

**Non** nella pagina `Pages/List<Plurale>.php`. Quello che scrivi li' dentro non viene
letto da nessuno.

```php
namespace Modules\Tenant\Filament\Resources\FooResource\Tables;

use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class FoosTable extends XotBaseResourceTable

### `filament-version.md` — Filament Version Declaration — Tenant

# Filament Version Declaration — Tenant

**Current Version**: Filament v5 (Livewire v4 + Schemas)

This module/theme is developed against **Filament v5**.

All resources, forms, tables, infolists, widgets and actions must follow the v5 + XotBase patterns documented in:

- `docs/wiki/rules/filament-rules-summary.md`
- `docs/wiki/memories/filament-version-policy.md`
- `laravel/Modules/Xot/docs/filament-5-laraxot-rules.md`

**Legacy v4 documents** in this folder (if any) are historical only and must not be used as current reference.

**Last verified**: 2026-05-21

**Firmato:** Cursor Agent (Composer) — template propagato ai package `docs/`

### `file-naming-rules.md` — Regole di Naming per File

# Regole di Naming per File

## 🎯 Regola Fondamentale: NO Duplicati Case-Insensitive

### Problema

Su filesystem case-insensitive (Windows, macOS default), file con nomi che differiscono solo per maiuscole/minuscole causano conflitti:

```
❌ ERRATO - Duplicati case-insensitive:
- README.md e README.md
- Activity.php e activity.php
- listrecords.md e listrecords.md
```

### Soluzione

**Mantenere SOLO la versione con naming corretto secondo le convenzioni:**

## 📋 Convenzioni di Naming

### `filesystems.md` — filesystems



### `folio-volt-best-practices.md` — Laravel Folio + Volt - Best Practices and Patterns Analysis

# Laravel Folio + Volt - Best Practices and Patterns Analysis

## Overview

Based on research of multiple Laravel Folio + Volt repositories and official documentation, this document outlines the best practices and patterns for implementing Folio + Volt in applications.

## Key Patterns Identified

### 1. File Structure
- **Pages Directory**: Folio automatically maps files in `resources/views/pages/` to routes
  - Example: `resources/views/pages/events.blade.php` → `/events`
  - Example: `resources/views/pages/events/[event].blade.php` → `/events/{event}`
- **Subdirectories**: Organize related pages in subdirectories (e.g., `resources/views/pages/auth/`)
- **Blade Components**: Store reusable UI components in `resources/views/components/`

### 2. Volt Component Structure
- Volt components c

### `frameworks.md` — Tenant — Framework Integration Notes


# Tenant — Framework Integration Notes

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

### `getting-started.md` — getting-started



### `git-multi-org-sync-handoff.md` — Handoff — multi-org sync (STORY-003)


# Handoff — multi-org sync (STORY-003)

## Scopo

Allineare questo owner ai remote raggiungibili (**0 0**, working tree clean) e documentare decisioni di sessione 2026-07-21.

## Perché

Un tree dirty o un remote dietro/avanti **non** è sincronizzato, anche se l’altro org è a posto. Su PTVX i path vivono in `gitmodules.ini` con org `provtv` (+ `laraxot` se esiste).

## Link

| Tipo | URL |
|------|-----|
| Issue owner | https://github.com/provtv/module_tenant_fila5/issues/14 |
| Discussion | https://github.com/provtv/base_ptv_fila5/discussions/204 |
| Hub base issue | https://github.com/provtv/base_ptv_fila5/issues/203 |
| Hub base discussion | https://github.com/provtv/base_ptv_fila5/discussions/204 |
| Story monorepo | `docs/stories/STORY-003-multi-org-sync-geo-boundary-bashscripts.md` 

### `git-push-lfs-incident.md` — Git push bloccato da oggetto Git LFS mancante


# Git push bloccato da oggetto Git LFS mancante

## Sintomo

```
$ git push
remote: error: GH008: Your push referenced at least 16 unknown Git LFS objects:
remote:     6126375ccbb3811d335007914fb1b2f90bf1ab199054855f602ad3de3d1121a1
remote:     ...
remote: Try to push them with 'git lfs push --all'.
 ! [remote rejected] dev -> dev (pre-receive hook declined)
```

Il push su `provtv` (remote di tracking del branch `dev`) veniva rifiutato dal
pre-receive hook di GitHub per Git LFS, non da un errore di codice.

## Studio delle vecchie versioni (nessun checkout/reset/revert)

Per ciascuno dei 16 oggetti LFS "unknown", ho ricostruito la storia del path

### `glossary.md` — Glossario di dominio Tenant


# Glossario di dominio Tenant

Se glossario e codice divergono vale il codice. Percorsi relativi a `laravel/Modules/Tenant/`.

| Termine | Significato | Nel codice |
|---|---|---|
| Tenant | Entità che identifica il contesto tenant (modello Eloquent). | `app/Models/Tenant.php` |
| Nome tenant | Percorso sotto `config/` ricavato dall'host con dominio invertito e slugato (es. `local/ptvx`) o `localhost`. | `app/Actions/GetTenantNameAction.php` |
| Config del tenant | File PHP in `config/<nome tenant>/` che sovrascrivono i default Laravel. | `app/Actions/Config/GetTenantFilePathAction.php` |
| Overlay | Config base Laravel con sopra `array_replace_recursive` l'override del tenant. | `app/Actions/Config/GetTenantConfigValueAction.php` |
| Percorso file tenant | Percorso assoluto di un file de

### `helper-functions-dependency.md` — Dipendenze Helper Functions - Modulo Tenant

# Dipendenze Helper Functions - Modulo Tenant

## 📋 Overview

Il modulo **Tenant** dipende da funzioni helper globali fornite dal modulo **Xot** per implementare configurazioni dinamiche context-aware.

**Status**: ✅ Fix implementato (2 Dicembre 2025)

## 🔗 Funzioni Helper Utilizzate

### 1. `inAdmin(): bool`

**Provider**: `Modules\Xot\Helpers\Helper.php`
**Wrapper per**: `Modules\Xot\Services\RouteService::inAdmin()`

**Uso nel Tenant**:

#### TenantService.php (linea 68)
```php
if (inAdmin() && Str::startsWith($key, 'morph_map') && Request::segment(2) !== null) {

### `html2pdf/advanced.md` — Funzionalità Avanzate

# Funzionalità Avanzate

Questa sezione copre funzionalità avanzate come la generazione di codici a barre, QR code, la creazione di segnalibri (bookmark), indici e altri metodi utili della libreria.

**Menu di Navigazione:**
*   [Panoramica e Installazione](./index.md)
*   [Utilizzo Base e Layout](./usage.md)
*   [Guida agli Stili](./styling.md)
*   [Integrazione con Laravel e Best Practices](./laravel.md)
*   [Configurazione della Sicurezza](./security.md)

---

## 📋 Codici a Barre e QR Code

### Barcode
Html2Pdf può generare diversi tipi di codici a barre direttamente nel PDF.

```html
<barcode type="C39" value="HTML2PDF" style="width: 40mm; height: 10mm; color: #000;"></barcode>

### `html2pdf/laravel.md` — Integrazione con Laravel e Best Practices

# Integrazione con Laravel e Best Practices

Questa guida si concentra su come integrare e utilizzare `Html2Pdf` in un'applicazione Laravel, seguendo le best practice specifiche del progetto Laraxot.

**Menu di Navigazione:**
*   [Panoramica e Installazione](./index.md)
*   [Utilizzo Base e Layout](./usage.md)
*   [Guida agli Stili](./styling.md)
*   [Funzionalità Avanzate](./advanced.md)
*   [Configurazione della Sicurezza](./security.md)

---

## 🔗 Integrazione con Laravel

### Service Provider
È consigliabile registrare `Html2Pdf` nel container di servizi di Laravel per una facile dependency injection.

```php
// In un ServiceProvider, ad esempio PdfServiceProvider.php

### `html2pdf/security.md` — Configurazione della Sicurezza

# Configurazione della Sicurezza

A partire dalla versione 5.3, `Html2Pdf` ha introdotto un `Security Service` per controllare l'accesso a risorse esterne (immagini, fogli di stile, etc.) e prevenire vulnerabilità.

**Menu di Navigazione:**
*   [Panoramica e Installazione](./index.md)
*   [Utilizzo Base e Layout](./usage.md)
*   [Guida agli Stili](./styling.md)
*   [Funzionalità Avanzate](./advanced.md)
*   [Integrazione con Laravel e Best Practices](./laravel.md)

---

## 🛡️ Security Service

Il servizio di sicurezza permette di definire policy per validare gli URI delle risorse esterne.

### Implementazione di una Policy di Sicurezza Personalizzata
È possibile creare una classe che implementa `Spipu\Html2Pdf\Security\SecurityInterface` per definire la propria logica di validazione.


### `html2pdf/styling.md` — Guida agli Stili, Tabelle e Immagini

# Guida agli Stili, Tabelle e Immagini

Questa guida illustra come applicare stili CSS, creare layout con tabelle e gestire le immagini nei PDF generati con Html2Pdf.

**Menu di Navigazione:**
*   [Panoramica e Installazione](./index.md)
*   [Utilizzo Base e Layout](./usage.md)
*   [Funzionalità Avanzate](./advanced.md)
*   [Integrazione con Laravel e Best Practices](./laravel.md)
*   [Configurazione della Sicurezza](./security.md)

---

## 🎨 Stili e CSS

Html2Pdf ha un supporto limitato per i CSS. La regola fondamentale è utilizzare **esclusivamente CSS inline** tramite l'attributo `style`. Tag `<style>` e fogli di stile esterni (`<link>`) non sono supportati.

#### ✅ CSS Inline Corretto
```html
<div style="font-family: Arial; font-size: 12pt; color: #333;">

### `html2pdf/usage.md` — Utilizzo Base e Layout

# Utilizzo Base e Layout

Questa sezione descrive l'utilizzo di base della libreria, come istanziare la classe `Html2Pdf` e come gestire il layout delle pagine con i tag speciali.

**Menu di Navigazione:**
*   [Panoramica e Installazione](./index.md)
*   [Guida agli Stili](./styling.md)
*   [Funzionalità Avanzate](./advanced.md)
*   [Integrazione con Laravel e Best Practices](./laravel.md)
*   [Configurazione della Sicurezza](./security.md)

---

## 🔧 Utilizzo Base

### Istanza Html2Pdf
```php
use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf(

### `investigation/investigation.md` — Investigation: Isolation Strategy

# Investigation: Isolation Strategy

## Problem Statement
Analisi delle feature mancanti nel modulo Tenant.

## Current State
- Documentazione esistente: 17 stories
- Architettura: Actions,Console,Contracts,Enums,Filament,Http,Models,Providers,Services,View,

## Feature Missing
1. Feature A - descrizione
2. Feature B - descrizione
3. Feature C - descrizione

## Proposed Solution
- Implementare le feature A/B/C usando le regole BMAD
- Seguire: no controller, no services layer, module providers manifest

## Acceptance Criteria
- [ ] APCA contrast ≥75 body, ≥45 large-bold

### `it/config/database.md` — Versione HEAD

<?php

declare(strict_types=1);

$mysql_def = [
    'driver' => 'mysql',
    'host' => env('DB_HOST', 'localhost'),
    'port' => env('DB_PORT', '3306'),
    'database' => 'mensa',
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
    'strict' => false,
    'engine' => null,
    'options' => [
        PDO::ATTR_EMULATE_PREPARES => true,
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,

### `it/config/event-sourcing.md` — Versione HEAD

<?php

return [

    /*
     * These directories will be scanned for projectors and reactors. They
     * will be registered to Projectionist automatically.
     */
    'auto_discover_projectors_and_reactors' => [
        app()->path(),
    ],

    /*
     * This directory will be used as the base path when scanning
     * for projectors and reactors.
     */
    'auto_discover_base_path' => base_path(),

    /*
     * Projectors are classes that build up projections. You can create them by performing

### `it/config/exchanges.md` — exchanges

<?php

declare(strict_types=1);

return [
    'coinbase' => [
        'key' => '',
        'secret' => '',
        'passphrase' => '',  //sarebbe extra ?
        'host' => 'https://api.coinbase.com',
    ],
];

### `it/config/filesystems.md` — filesystems

<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------

### `it/config/metatag.md` — Versione HEAD

<?php

declare(strict_types=1);

return [
    'title' => '',
    'sitename' => '',
    'logo_header' => 'ptv::img/logo.png',
    'logo_header_dark' => 'ptv::img/icon.png',
    'subtitle' => '',
    'sottotitolo_comune' => '',
    'generator' => '',
    'charset' => 'UTF-8',
    'author' => '',
    'description' => '',
    'keywords' => '',
    'nome_regione' => '',
    'nome_comune' => '',
    'site_title' => '',
    'logo_img' => '',

### `it/config/modules-statuses.md` — Modules Statuses — due file indipendenti, non uno solo


# Modules Statuses — due file indipendenti, non uno solo

Questo progetto ha **due file `modules_statuses.json` completamente separati**, con
scopi diversi. Confonderli (o dimenticarsi del secondo) produce un bug silenzioso:
un modulo perfettamente funzionante ma invisibile nel menu di navigazione admin.

## 1. Root — `laravel/modules_statuses.json`

Letto da nwidart/laravel-modules (`config('modules.activators.file.statuses-file')`
→ `base_path('modules_statuses.json')`). Controlla se il `ServiceProvider` del
modulo viene registrato/booted da Laravel. Se un modulo è `false` qui, non esiste
per l'applicazione: niente rotte, niente migrazioni, niente Eloquent.

## 2. Tenant-scoped — `config/{tenant}/modules_statuses.json`

Risolto dinamicamente per hostname. Per workorder, `config/local/wo

### `it/config/morph-map.md` — morph-map

<?php

return ['user' => \Modules\Xot\Datas\XotData::make()->getUserClass()];
<?php

return ['user' => \Modules\Xot\Datas\XotData::make()->getUserClass()];

### `it/config/passport.md` — Laravel Passport Configuration (Version 13.4.x)

# Laravel Passport Configuration (Version 13.4.x)

## Overview
This file documents the configuration options for Laravel Passport in the Tenant module.

## Config File (`config/passport.php`)
```php
return [
    // Encryption keys used to sign access tokens
    'private_key' => env('PASSPORT_PRIVATE_KEY'),
    'public_key' => env('PASSPORT_PUBLIC_KEY'),

    // Use UUIDs for client IDs?
    'client_uuids' => false,

    // Personal access client credentials
    'personal_access_client' => [
        'id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
        'secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
    ],

### `it/config/permission.md` — Versione HEAD

<?php

declare(strict_types=1);

use Modules\User\Models\Permission;
use Modules\User\Models\Role;

return [
    'models' => [
        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `Spatie\Permission\Contracts\Permission` contract.
         */

        // 'permission' => Spatie\Permission\Models\Permission::class,
        'permission' => Permission::class,

### `it/config/services.md` — Versione HEAD

<?php

declare(strict_types=1);

return [
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],
    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => env('TWITTER_REDIRECT_URI'),
    ],
    'instagram' => [
        'client_id' => env('INSTAGRAM_KEY'),
        'client_secret' => env('INSTAGRAM_SECRET'),
        'redirect' => env('INSTAGRAM_REDIRECT_URI'),
    ],

### `it/config/social.md` — Versione HEAD

<?php

declare(strict_types=1);

return [
    'items' => [
        (object) [
            'name' => 'facebook',
            'url' => '#',
            //'icon'=>'<i fa fa-face'>
        ],
        (object) [
            'name' => 'instagram',
            'url' => '#',
        ],
        (object) [
            'name' => 'pinterest',
            'url' => '#',
        ],
        (object) [

### `it/customizing-your-site.md` — Customizing Your Site {#customizing}

# Customizing Your Site {#customizing}

## Styles

This starter template comes pre-loaded with [Tailwind CSS](https://tailwindcss.com), a utility CSS framework that allows you to customize and build complex designs without touching a line of CSS. There are also a few base Sass files in the `/source/_assets/sass` folder, set up with the expectation that you can add any custom CSS into `_documentation.scss`.

> You can re-work the architecture of the Sass includes any way you’d like; just make sure to keep the `@tailwind` references in your final files.

```scss
// source/_assets/sass/main.scss

@tailwind preflight;
@tailwind components;

// Code syntax highlighting,
// powered by https://highlightjs.org
@import '~highlight.js/styles/a11y-light.css';

@import 'base';
@import 'navigation';

### `it/getting-started.md` — Modulo Tenant {#modulo-tenant}


# Modulo Tenant {#modulo-tenant}

Questo modulo è dedicato alla gestione delle configurazioni dei vari domini utilizzati nella base.

Il modulo "module_tenant" è un pacchetto per Laravel che fornisce funzionalità per la gestione del multitenant in un'applicazione Laravel. Il multitenant consiste nella possibilità di gestire più tenant, ossia più clienti o utenti, all'interno di un'unica applicazione.

Per utilizzare il modulo, è necessario installarlo tramite Composer con il comando composer require laraxot/module_tenant. Una volta installato, il modulo può essere utilizzato nell'applicazione Laravel tramite il seguente codice:

Copy code
use Laraxot\ModuleTenant\Facades\ModuleTenant;
Il modulo include diverse funzionalità per la gestione del multitenant, come ad esempio il metodo addTena

### `it/phpunit.md` — phpunit

https://iwasherefirst2.medium.com/how-to-test-eloquent-models-in-a-laravel-package-3dbf30b44a19

### `it/project-configurations.md` — Configurazione progetti {#configurazione-progetti}


# Configurazione progetti {#configurazione-progetti}

Con lo stessa struttura è possibile avere varie configurazioni per gestire più progetti.

## Cartella config {#cartella-config}

Dentro la cartella laravel\config ci sono tutte le configurazioni, organizzate in base all'url utilizzato.

L'organizzazione delle cartelle segue l'ordine del dominio, esempio:

se volessi configurare il dominio https://mio_dominio.com/, dentro la cartella laravel\config dovrei creare:

una cartella nominata **com**,

dentro la cartella com un altra cartella nominata **mio_dominio**.

quindi tutti i file di configurazione che interessano al progetto che verrà pubblicato a dominio https://mio_dominio.com/ si troveranno dentro la cartella **laravel/config/com/mio_dominio"**

### `it/trait-method-implementation.md` — Trait Method Implementation Rules

# Trait Method Implementation Rules

## Critical: DRY Principle for Trait Methods

**NEVER** duplicate trait methods in individual models! This violates DRY (Don't Repeat Yourself).

### Wrong Pattern (What was done 2026-03-02)
```php
// ❌ WRONG - Duplicating getJsonFile() in 4 models (Attachment, Menu, PageContent, Section)
class Attachment extends BaseModel
{
    use SushiToJsons;
    
    public function getJsonFile(): string // DUPLICATE!
    {
        // implementation
    }
}

class Menu extends BaseModel

### `license-full.md` — license-full

The MIT License (MIT)

Copyright (c) :vendor_name <author@domain.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTI

### `log-error-resolution.md` — Risoluzione errori di bootstrap e log

# Risoluzione errori di bootstrap e log

## Causa

Il file `GetTenantFilePathAction.php` conteneva marker di conflitto Git annidati
(`<<<<<<<`, `=======`, `>>>>>>>`). Il file non era PHP valido e il bootstrap
falliva mentre caricava la configurazione tenant. Laravel registrava quindi sia
il `ParseError` sia l'errore secondario `Log [] is not defined`, perché il logger
non riusciva a inizializzarsi durante la gestione dell'eccezione.

## Correzione

La risoluzione conserva entrambe le intenzioni compatibili: prepara la copia
isolata dei contenuti tenant per i test e usa il path sorgente per inizializzare
la copia sotto `storage/framework/testing/tenant-content`.

## Verifica

- `php -l Modules/Tenant/app/Actions/Config/GetTenantFilePathAction.php`
- `php artisan about`

### `mcp-configuration.md` — MCP Server Configuration - Tenant Module

# MCP Server Configuration - Tenant Module


**Status**: ✅ Configured
**MCP Servers**: Asana, ClickUp, Filesystem, Database, Redmine (Planned)

---

## 📋 Overview

The Tenant module's MCP configuration enables AI assistants to interact with:
- **Asana Work Graph** - Task and project management
- **ClickUp Workspace** - Advanced task workflows and time tracking
- **Redmine** - Project management (planned, requires self-hosted instance)
- **Filesystem** - Direct file access
- **Database** - SQLite queries for data inspection

---

## 🔧 Configuration

### `mcp-server-recommended.md` — MCP Server Consigliati per il Modulo Tenant

# MCP Server Consigliati per il Modulo Tenant

## Scopo del Modulo
Gestione multi-tenant, isolamento dati e provisioning tenant.

## Server MCP Consigliati
- `filesystem`: Per gestione file e configurazioni tenant.
- `fetch`: Per provisioning e sincronizzazione dati tra tenant.
- `memory`: Per stato temporaneo e sessioni tenant.

## Configurazione Minima Esempio
```json
{
  "mcpServers": {
    "filesystem": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-filesystem"] },
    "fetch": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-fetch"] },
    "memory": { "command": "npx", "args": ["-y", "@modelcontextprotocol/server-memory"] }
  }
}
```

### `merge-conflict-files-list.md` — Merge Conflict Files List

# Merge Conflict Files List

This file contains a comprehensive list of files with merge conflict markers (`<<<< HEAD` or `<<<< .merge_file`) that need to be resolved.

## Total Files Found: 96

## Files by Module/Theme:

### Core Modules (16 files)
- ./.planning/debug/knowledge-base.md
- ./.planning/debug/resolved/sqlite-model-contract-fix.md
- ./_bmad/bmm/4-implementation/bmad-create-story/stories/1-1-segnalazione-ui-ux-improvement.md
- ../../Notify/docs/bugs/summary-2.md
- ../../Notify/docs/bugs/summary-2.md
- ../../Notify/docs/bugs/summary-2.md
- ./bashscripts/ai/.agents/skills/directory-structure/SKILL.md
- ./bashscripts/ai/.agents/skills/module-roadmap/SKILL.md
- ./bashscripts/ai/.agents/todos/0607894a-18a3-4b7e-a867-cf1d0ceecac0-agent-0607894a-18a3-4b7e-a867-cf1d0ceecac0.json
- ./ba

### `merge-conflicts-list.md` — Merge conflict markers — file list

# Merge conflict markers — file list

Elenco dei file trovati contenenti marker di merge (<<<<<<<, >>>>>>>, .merge_file). Seguire la lista per assegnare task agli agenti.

## Lista (auto-generata)

- memory/MEMORY.md
- _bmad/bmm/4-implementation/bmad-create-story/stories/1-1-segnalazione-ui-ux-improvement.md
- laravel/Themes/Sixteen/public/manifest.json
- bashscripts/ai/wiki/concepts/modules-structure-rules.md#no-docs-archive-rule
- docs/wiki/index.md
- docs/wiki/log.md
- laravel/Themes/Sixteen/docs/wiki/index.md
- laravel/Themes/Sixteen/docs/wiki/log.md
- laravel/Modules/Lang/docs/module-analysis.md
- laravel/Modules/Lang/docs/translatable/json-content-translation.md
- laravel/Modules/Lang/docs/module.md
- laravel/Modules/Notify/docs/wiki/index.md
- laravel/Modules/Geo/resources/js/compon

### `metatag.md` — metatag



### `metodi-duplicati-analisi.md` — 🐄⚡ ANALISI METODI DUPLICATI - SUPER MUCCA EDITION

# 🐄⚡ ANALISI METODI DUPLICATI - SUPER MUCCA EDITION

**Powered by**: Super Mucca AI 🐄✨  
**Data**: 15 Ottobre 2025  
**Versione**: 2.0 ULTIMATE  
**Confidenza**: 99.9% (Dati Reali dal Codice)

---

## 🎯 Executive Summary

Analisi **REALE e APPROFONDITA** di **18 moduli** + **2 temi** del framework Laraxot/Filament.

### Dati Chiave (VERIFICATI)

| Metrica | Valore | Fonte |
|---------|--------|-------|
| **Moduli Analizzati** | 18 | Directory scan |
| **Temi Analizzati** | 2 (Sixteen, TwentyOne) | Directory scan |
| **BaseModel Totali** | 10 | File count |

### `metodiuplicati-analisi.md` — 🐄⚡ ANALISI METODI DUPLICATI - SUPER MUCCA EDITION

# 🐄⚡ ANALISI METODI DUPLICATI - SUPER MUCCA EDITION

**Powered by**: Super Mucca AI 🐄✨  
**Versione**: 2.0 ULTIMATE  
**Confidenza**: 99.9% (Dati Reali dal Codice)

---

## 🎯 Executive Summary

Analisi **REALE e APPROFONDITA** di **18 moduli** + **2 temi** del framework Laraxot/Filament.

### Dati Chiave (VERIFICATI)

| Metrica | Valore | Fonte |
|---------|--------|-------|
| **Moduli Analizzati** | 18 | Directory scan |
| **Temi Analizzati** | 2 (Sixteen, TwentyOne) | Directory scan |
| **BaseModel Totali** | 10 | File count |
| **LOC BaseModel** | 578 linee | wc -l |

### `migration-patterns.md` — migration-patterns



### `models-factory-seeder-analysis.md` — models-factory-seeder-analysis



### `modular-monolith-architecture.md` — Modular Monolith Architecture for Tenant Module

# Modular Monolith Architecture for Tenant Module

## Overview

This document outlines the architectural guidelines for implementing a modular monolith pattern in the Tenant module, following the principles outlined in the [Architecting Laravel the Right Way](https://medium.com/@mohamadshahkhajeh/architecting-laravel-the-right-way-modular-monoliths-done-right-ef-b8-8f-62d30a8b0efd) article while adhering to our project's standards and conventions.

## Core Principles

1. **Module Autonomy**
   - Each module is a self-contained unit with its own:
     - Domain logic
     - Application services
     - Infrastructure code
     - UI components

2. **Strict Boundaries**
   - Modules communicate through well-defined interfaces
   - No direct dependencies between modules' internals
   - Shared ke

### `modular-monolithlines.md` — Modular Monolith Guidelines for Laravel

# Modular Monolith Guidelines for Laravel

## Overview
This document outlines the best practices for structuring a Laravel application as a modular monolith. This approach combines the simplicity of monolithic architecture with the scalability and organization of microservices.

## Key Concepts

### What is a Modular Monolith?
A modular monolith is a single application with strictly defined internal modules. Each module owns its domain, exposes minimal interfaces, and hides its internal logic from the rest. This ensures clean separation and future readiness, similar to microservices without the distributed complexity.

### Common Pitfalls in Laravel Monoliths
- Giant controllers
- Bloated service classes
- Cross-module spaghetti logic
- Painful refactors

These issues arise from a lack of 

### `module-analysis.md` — Modulo Tenant - Multi-Tenancy Management


# Modulo Tenant - Multi-Tenancy Management

## Scopo Principale

Il modulo **Tenant** fornisce un sistema completo di **multi-tenancy per il monolite Laraxot**, permettendo di gestire multiple istanze dell'applicazione con isolamento completo dei dati, configurazioni e utenti.

## Funzionalità Implementate

### ✅ Core Tenancy System
1. **Tenant Management**
   - Complete CRUD operations per tenant
   - Dynamic database connection per tenant
   - Tenant domain/subdomain routing
   - Tenant configuration management

2. **Data Isolation**
   - Database-per-tenant pattern
   - Schema isolation strategies
   - Tenant-specific data segregation

### `module.md` — Tenant Module — Doctrine


# Tenant Module — Doctrine

## Scope (Scopo)

Tenant gestisce l'isolamento multi-tenant del monorepo. Ogni tenant ha il proprio database (database isolation), configurazione JSON in `database/content/tenants/`, e feature flags propri. Il middleware tenant è applicato a ogni route che richiede contesto tenant.

## Religion (Religione)

**"Un tenant, un database, una configurazione, invisibile agli altri."** La convinzione non negoziabile è che i dati di un tenant NON devono mai essere accessibili da un altro tenant, nemmeno per errore. L'isolamento è a livello di database, non di `tenant_id` column — quest'ultimo è considerato un anti-pattern per rischio di data leak.

## Philosophy (Filosofia)

- **Database isolation**: ogni tenant ha il proprio database, non una colonna `tenant_id`
- **J

### `moduleses.md` — moduleses



### `morph-map.md` — morph-map



### `multi-org-sync-laraxot-provtv.md` — Sincronizzazione multi-organizzazione (laraxot + provtv)


# Sincronizzazione multi-organizzazione (laraxot + provtv)

## Cosa è stato fatto

Questo repository è tracciato da due remote GitHub (`laraxot` = org upstream canonica,
`provtv` = org operativa del progetto ptvx). Il 2026-07-21 è stata eseguita una
sincronizzazione completa seguendo `bashscripts/tools/prompts/02-gitmodules-sync.md`:
fetch di tutti i remote, quality gates (PHPStan L10, PHPMD), risincronizzazione dopo ogni modifica.

## Problemi riscontrati e risolti

- **Clone shallow**: il repo era stato clonato con storia troncata, causando push
  respinti (`did not receive expected object`). Fix: `git fetch --unshallow` su tutti i remote.
- **Storie scollegate ("unrelated histories")**: alcuni repo avevano un branch `dev`
  remoto rigenerato senza antenato comune con la storia locale. 

### `nested-resources.md` — Tenant Module - Nested Resource Implementation Guide

# Tenant Module - Nested Resource Implementation Guide

## Overview

The Tenant module implements comprehensive multi-tenancy functionality with database isolation, providing the foundation for multi-client support in the Laraxot system. Nested resources in this module focus on organizing tenant-related data and relationships in a hierarchical structure that supports multi-tenant operations.

## Current Relationship Structure

### Tenant Model Relationships
- `Tenant` hasMany `User` (via tenant_user relationship)
- `Tenant` hasMany `Domain`
- `Tenant` hasMany `Customer` (via customer-tenant relationship)
- `Tenant` hasMany `SurveyPdf` (via customer-tenant relationship)
- `Tenant` hasMany `ActivityLog` (tenant-specific logs)

### Domain Model Relationships
- `Domain` belongsTo `Tenant`

###

### `nestedset-migration-best-practices.md` — NestedSet Migration Best Practices - Tenant Module

# NestedSet Migration Best Practices - Tenant Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo Tenant utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Struttura Tenant

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\Tenant\Models\Tenant::class;

    public function up(): void

### `no-ai-tool-scaffold-dirs.md` — Perché queste cartelle non devono esistere qui


# Perché queste cartelle non devono esistere qui

Regola canonica: [module-theme-root-cleanup.md — Rule 5](../../../../docs/wiki/rules/module-theme-root-cleanup.md).

Rimosse in questo modulo: `_docs/`, `scripts/`, `bashscripts/`, `docs/archive|archived|legacy|workbench/`, `.circleci/`, `.claude-audit/`, `tests/.claude-audit/`, `_bmad-output/`, `test-results/`, `.devcontainer/`, `.kilocode/`, `.kiro/`, `.ralph/` (dove presenti) e aggiunte al `.gitignore` di questo modulo.

**Perché**: questo modulo vive anche come repo Git indipendente (multi-repo); ogni agente/tool AI o pipeline CI che gira in quella root scrive lì la propria cache/scaffold locale (skill `.kiro/`, output `_bmad-output/`, stato `.ralph/`, audit `.claude-audit/`, log `test-results/`), ignorando che quella root è in realtà 

### `no-git-lfs.md` — Git LFS non si usa in questo progetto


# Git LFS non si usa in questo progetto

Vale per il repo root, per `bashscripts/` e per ogni modulo e tema. Questo modulo non fa
eccezione.

## La regola

I binari — immagini, font, PDF, archivi — si versionano come **blob git normali**.

Vietato:

- aggiungere `filter=lfs diff=lfs merge=lfs` in un qualunque `.gitattributes`;
- eseguire `git lfs install` o `git lfs track` dentro questo repo;
- committare come contenuto di un file il testo `version https://git-lfs.github.com/spec/v1`.

## Perche'

Non e' una preferenza di stile, e' il risultato di incidenti ripetuti.


### `no-phpstan-probe-policy.md` — No PHPStan probe files in Tenant


# No PHPStan probe files in Tenant

## Regola

Nel modulo `Tenant` non devono esistere:

- directory `app/Phpstan`
- file che finiscono per `PhpstanProbeModel.php`
- file che finiscono per `PhpstanTraitProbe.php` o nomi simili (probe fittizi)

## Perché

Questi file sono modelli o classi artificiali create solo per far passare PHPStan.
Se un trait risulta non usato nel modulo, si aggiunge `@phpstan-ignore trait.unused`
nel docblock del trait. Se un test deve esercitare un trait, si usa una classe
anonima o una fixture reale collegata a un test Pest esistente (non un probe).

Il ragionamento completo (logica/politica/filosofia/religione/zen di questo divieto) è
in `Modules/Xot/docs/wiki/concepts/phpstan-trait-probes.md`.

### `on-demand-pattern.md` — On-Demand Pattern — Module **Tenant**


# On-Demand Pattern — Module **Tenant**

**Fonte canonica**: [../../docs/wiki/rules/on-demand-pattern.md](../../docs/wiki/rules/on-demand-pattern.md)

## Principio

Questo module segue il **pattern on-demand** per rules, skills, commands e memories:

- ✅ **Vivono solo nel wiki** — ../../docs/wiki/
- ✅ **Caricati on-demand** — via trigger map o `qmd search`
- ❌ **NON pre-caricati** — mai embeddare nei bootstrap files
- ❌ **Nessuna duplicazione** — wiki = sorgente di verità unica

## Perché On-Demand?

1. **Contesto minimo** — Carico solo le regole pertinenti al task corrente
2. **Token efficient** — Nessun carico inutile all'avvio (~50K → ~2K token)
3. **Scalabile** — Aggiungere nuove rules non richiede modifiche ai bootstrap
4. **Manutenibile** — Una sola fonte di verità (wiki)

### `optimization-analysis.md` — optimization-analysis



### `package-dependency-chaos-map.md` — Package Dependency Chaos Map (Tenant)

# Package Dependency Chaos Map (Tenant)

## Catalogo completo
- [Composer Packages Full Catalog (2026-03-02)](../../Xot/docs/composer-packages-full-catalog.md)

## Pacchetti studiati rilevanti
- `laravel/framework`
- `nwidart/laravel-modules`
- `spatie/laravel-data`
- `predis/predis`

## Rischi principali
1. Isolamento tenant compromesso da config connessioni non standard.
2. Mappatura ambiente testing divergente da produzione.
3. Risoluzione tenant errata su host/runtime.

## Test operativo minimo
```bash
php artisan test --filter=Tenant --compact
./vendor/bin/phpstan analyze Modules/Tenant --level=10

### `packages.md` — packages



### `passport.md` — passport



### `patterns.md` — Tenant Module Design Patterns


# Tenant Module Design Patterns

**Last updated: 2026-07-28**

This document describes the core architectural patterns used in the Tenant module to ensure isolation, security, and maintainability.

---

## 1. Tenant Isolation Pattern

### Purpose
Ensure complete data separation between tenants with no cross-tenant data leakage.

### Strategy
- **Database-Level**: Each tenant uses separate database or schema
- **Query Scoping**: Automatic query filters on tenant context
- **Connection Resolution**: Smart routing to correct database connection

### Implementation Checklist

### `performance-optimization.md` — Performance Optimization — Module **Tenant**


# Performance Optimization — Module **Tenant**

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

### `permission.md` — permission



### `philosophy.md` — Tenant Module: Philosophy, Religion, and The Art of Safe Isolation


# Tenant Module: Philosophy, Religion, and The Art of Safe Isolation

**Version:** 2.0  
**Date:** September 2026  
**Status:** Living Document  
**Audience:** Architects, Senior Developers, DevOps, Product Owners

---

title: "PHILOSOPHY"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "PHILOSOPHY"
issues: []
discussions: []
## RELIGIONE: The Sacred Dogmas of Multi-Tenancy


### `phpstan-fix-plan/queueable-actions-conversion-plan.md` — Conversione Tenant Services a Spatie Queueable Actions — Piano Decisionale

# Conversione Tenant Services a Spatie Queueable Actions — Piano Decisionale

**Data**: 2026-10-20
**Modulo**: Tenant
**Path sorgente**: `laravel/Modules/Tenant/app/Services/`
**Obiettivo**: Convertire i servizi a Spatie Queueable Actions preservando la logica esistente e documentando le decisioni.

---

## 1. Pattern di riferimento (DbForge)

Il pattern QueueableAction utilizzato nel progetto si basa su:

```php
use Spatie\QueueableAction\QueueableAction;

class NomeAction
{
    use QueueableAction;


### `phpstan-fixes.md` — PHPStan Fixes - Tenant Module - 2025-10-13


# PHPStan Fixes - Tenant Module - 2025-10-13

## Summary

**Starting Errors**: 82
**Current Errors**: 24
**Progress**: 71% reduction (58 errors fixed)

## Major Fixes Implemented

### 1. Skipped Invalid Test File
**File**: `tests/Feature/TenantBusinessLogicTest.php` → `.php.skip`

**Reason**: Test file references models that don't exist:
- `TenantDomain` (should be `Domain`?)
- `TenantSetting` (not created)
- `TenantSubscription` (not created)

**Impact**: Removed 82 errors from non-existent model references

### `phpstan-roadmap.md` — PHPStan Level 10 Roadmap - Tenant Module


# PHPStan Level 10 Roadmap - Tenant Module

**Data**: 2026-01-30
**Status**: 🟡 In Progress
**Errori Totali**: 581 (Iniziali)

## Analisi Errori
La quasi totalità degli errori (99%) si trova nella directory `Tests`.

### Top Offender Files
- `Tests/Unit/SushiToJsonTraitTest.php`: 197 errori
- `Tests/Feature/TenantBusinessLogicTest.php`: 155 errori
- `Tests/Unit/SushiToJsonTraitPestTest.php`: 110 errori

### Pattern Principali
1. **Mixed Method Calls**: `Cannot call method create() on mixed` (36)
2. **Mixed Property Access**: `Cannot access property $id on mixed` (35)
3. **Pest Internal Access**: `Call to method toBe() ... from outside its root namespace` (32)
4. **Undefined Properties**: `Access to an undefined property PHPUnit\Framework\TestCase::$model` (30)

### `phpunit.md` — phpunit



### `ponytail-audit-over-engineering.md` — Ponytail audit — Tenant (over-engineering)

# Ponytail audit — Tenant (over-engineering)

**Ultimo run:** 2026-06-30  
**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)
**Remediation:** [../../../../docs/project/ponytail-audit-remediation.md](../../../../docs/project/ponytail-audit-remediation.md)
**GitHub monorepo:** [Issue #221](https://github.com/laraxot/<nome repository>/discussions/228)

## Esito run 2026-06-30

Lean già sul perimetro codice principale. Nessun finding P0–P1 nel run repo-wide.

Eventuali voci storiche (ActivityLogger, contratti Geo) sono in [docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md).

## Collegamenti

- [wiki/concepts/quality-testing-verification.md#ponytail-audit](./wiki/concepts/ponytail-audit.md)

### `prd.md` — Product Requirements Document (PRD) - Tenant Module

# Product Requirements Document (PRD) - Tenant Module

**Module**: Tenant
**Version**: 1.0
**Status**: Draft
**Author**: Product Team

---

## Document Control

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2026-03-12 | Product Team | Initial draft |

---

## 1. Executive Summary

### 1.1 Problem Statement

### `product-requirements.md` — Product Requirements Document (PRD)

# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **
| **Owner** | Core Team |
| **Module** | Tenant |
| **Repository** | laraxot/module_tenant_fila5 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo Tenant implementa l'architettura **multi-tenant** per l'ecosistema Laraxot. Permette a una singola istanza dell'applicazione di servire organizzazioni multiple con **isolamento dati completo**.


### `project-configurations.md` — project-configurations



### `project-structure.md` — Project Structure — Module **Tenant**


# Project Structure — Module **Tenant**

## Directory Structure

\`\`\`
./laravel/Modules/Tenant/docs/
├── wiki/                          # Knowledge base locale (LLM Wiki)
│   ├── index.md                  # Master catalog
│   ├── log.md                    # Activity log
│   ├── concepts/                 # Topic/theme pages
│   ├── entities/                 # Organization/person pages
│   ├── rules/                    # ⚠️ 151+ regole progettuali
│   │   ├── 00-index.md          # Indice regole
│   │   ├── 00-TRIGGER_MAP.md    # Trigger map (link a globale)
│   │   └── *.md                 # Regole specifiche modulo
│   ├── skills/                   # Skill progettuali
│   │   ├── index.md
│   │   └── *.md
│   ├── commands/                 # Comandi progettuali

### `prompts/push.md` — push


va nella cartella laravel/Modules/Tenant e fa git push , capisci gli errori sistameli e documenta come hai risolto dentro laravel/Modules/Tenant/docs ti ricordo che con git andiamo solo in avanti, percio' non puoi fare checkout revert rollback, ma puoi anzi devi studiare le vecchie versioni e ti ricordo che il tuo lavoro non e' finito finche' non supera anche il controllo di phpstan phpmd, phpinisghts tutta la cartella laravel/Modules/Tenant

### `purpose.md` — Tenant — perche' esiste


# Tenant — perche' esiste

## Lo scopo in una frase

**Tenant permette a una sola installazione di servire piu' enti senza che nessuno veda
i dati dell'altro, e di farlo cambiando configurazione invece che codice.**

## L'evidenza

- `Domain`, `TenantDomain` — il tenant si riconosce **dall'URL**: e' la strategia meno
  invasiva e la meno fragile.
- `TenantSetting` — cio' che varia fra enti e' un dato.
- `DatabaseConfig` — isolamento che puo' arrivare fino a basi dati separate.
- `TenantSubscription` — un tenant ha un ciclo di vita.
- `BaseModelJsons`, `TestSushiModel` — configurazione da file JSON letta come se fosse
  una tabella (Sushi).
- Solo 52 file PHP: **la potenza sta nella posizione, non nel volume**. E' attraversato
  da ogni richiesta.


### `qmd-setup.md` — QMD Setup per Module **Tenant**


# QMD Setup per Module **Tenant**

## Configurazione QMD per Questo Module

### Collection Configuration

Il progetto usa una collection QMD centralizzata in `.qmd/index.yml` che include tutti i moduli.

### Ricerca Locale vs Globale

**Ricerca locale** (solo questo modulo):
\`\`\`bash
qmd search "<topic>" -c tenant
# Cerca solo in ./laravel/Modules/Tenant/docs/wiki/
\`\`\`

**Ricerca globale** (tutto il progetto):
\`\`\`bash
qmd search "<topic>"

### `quality-analysis.md` — Analisi Qualità - Modulo Tenant

# Analisi Qualità - Modulo Tenant

**Ultimo aggiornamento**: [DATE]
**Tool utilizzati**: PHPStan (Level 9), PHPMD, PHPInsights, Pint

---

## 📊 Stato Attuale

### PHPStan
- ✅ **Errori totali**: 0 (Pest.php fixato con pattern standard)
- **Livello**: 9 (target: 10)

### PHPMD
**Problemi principali identificati**:
- StaticAccess warnings (facades) - **Normale**, non critico
- UnusedFormalParameter - Parametri non utilizzati in Policy
- CyclomaticComplexity alto in:
  - `GetTenantConfigValueAction::execute()` - Complexity 15 (threshold 10)
  - `SushiToCsv::bootSushiToCsv()` - Complexity 27 (threshold 10)

### `quality-audit.md` — Audit di qualita — modulo Tenant


# Audit di qualita — modulo Tenant

Misurato il 1 settembre 2026 a tree fermo. Ogni numero viene da un comando
eseguito, non da una stima; i comandi sono in fondo, cosi la misura si puo
rifare e contestare.

## Stato misurato

| Metrica | Valore |
|---|---:|
| File PHP | 139 |
| Righe di codice | 11061 |
| File di test `*Test.php` | 29 |
| Casi di test | 173 |
| Casi di test per file PHP | 1.24 |
| `@phpstan-ignore` nel codice | 0 |
| Rilievi PHPMD su `app/` | 4 |
| PHPInsights — Code | 91.8 % |
| PHPInsights — Complexity | 100.0 % |

### `quality-gates.md` — Quality gates — Modules/Tenant


# Quality gates — Modules/Tenant

Verifica completa richiesta dopo il fix dell'incidente Git LFS (vedi
`git-push-lfs-incident.md`), su **tutta** la cartella
`laravel/Modules/Tenant`, non solo sui file toccati.

## PHPStan

```
cd laravel && php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Tenant --memory-limit=-1 --no-progress
```

**Risultato: `[OK] No errors`**

## PHPMD

```
cd laravel && bash tools/phpmd.sh Modules/Tenant/app text Modules/Tenant/phpmd.ruleset.xml
```

### `quality-report.md` — Quality Report — Tenant


# Quality Report — Tenant

Aggiornato: 2026-08-24. Rigenera con: `bashscripts/tools/quality-report.sh Tenant`

| Metrica | Valore |
|---|---|
| File PHP (app/) | 52 |
| LOC app/ | 3684 |
| File test | 41 |
| LOC test | 5124 |
| Test/App LOC ratio | 139.1% |
| PHPStan (level max) |  |

## Come misurare la coverage Pest

```bash
cd laravel
XDEBUG_MODE=coverage php -d memory_limit=2G ./vendor/bin/pest Modules/Tenant/tests \
  --coverage-text --colors=never

### `readme-en.md` — 🏢 Tenant — English presentation

# 🏢 Tenant — English presentation

[![Domain-Multi-Tenant](https://img.shields.io/badge/Domain-Multi--Tenant-283593.svg)](#)
[![Laravel 13](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com/)
[![Filament 5](https://img.shields.io/badge/Filament-5-ffab00.svg)](https://filamentphp.com/)
[![PHP 8.4+](https://img.shields.io/badge/PHP-8.4+-777BB4.svg)](https://php.net/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PSR-12](https://img.shields.io/badge/Code-PSR--12-blue.svg)](https://www.php-fig.org/psr/psr-12/)
[![Strict Types](https://img.shields.io/badge/PHP-strict__types-1-informational.svg)](#)
[![Laraxot Modules](https://img.shields.io/badge/Architecture-Modular-purple.svg)](#)
[![Current Platform](https:

### `readme.en.md` — Tenant

# Tenant

The **Tenant** module enables multi-tenancy in the Laraxot modular monolith: it resolves the current tenant (domain / path / context), isolates configuration and data, and provides the foundation to run multiple organizations on a single installation.

## What you get

- **Reliable tenant resolution**
- **Data isolation** (depending on the project strategy)
- **Integration with authentication and permissions**
- **Extensible structure**: each project can customize behavior without forking

## Quickstart

This repository is a modular monorepo: the module already lives in `laravel/Modules/Tenant`.

- **Enable the module**
  - `php artisan module:enable Tenant`
- **Run global migrations**
  - `php artisan migrate`


### `readme.it.md` — Tenant

# Tenant

Il modulo **Tenant** abilita la multi-tenancy nel monolite modulare Laraxot: identifica il tenant (domain / path / contesto), isola configurazioni e dati, e fornisce le fondamenta per gestire più organizzazioni in un’unica installazione.

## Cosa ottieni (in pratica)

- **Tenant resolution affidabile**
- **Isolamento dei dati** (in base alla strategia del progetto)
- **Integrazione con autenticazione e permessi**
- **Struttura estendibile**: ogni progetto può personalizzare il comportamento senza fork

## Quickstart

Questo repository è un monorepo modulare: il modulo è già presente in `laravel/Modules/Tenant`.

- **Abilita il modulo**
  - `php artisan module:enable Tenant`
- **Esegui le migrazioni (globali)**
  - `php artisan migrate`


### `rector-conflict-resolution.md` — rector-conflict-resolution



### `redundancy-analysis.md` — redundancy-analysis

Redundancy analysis available: ../../Notify/docs/bugs/summary-2.md

### `redundancy-audit.md` — Tenant redundancy audit 2026-05-21


# Tenant redundancy audit 2026-05-21

High-risk findings:
- Duplicate FQCNs caused by case-only directories:
  - `database/Factories/TenantFactory.php` vs `database/factories/TenantFactory.php`
  - `database/Factories/DomainFactory.php` vs `database/factories/DomainFactory.php`
  - `database/Factories/TestSushiModelFactory.php` vs `database/factories/TestSushiModelFactory.php`
  - `database/Seeders/DomainsSeeder.php` vs `database/seeders/DomainsSeeder.php`
  - `database/Seeders/TestSushiSeeder.php` vs `database/seeders/TestSushiSeeder.php`
- Docs contain case-only duplicates and `docs/archive` variants.

Risk:
- Linux may load one path while WSL/Windows package sync sees another.
- Composer classmap and IDE indexes can disagree on the same class.

Suggested cleanup order:
1. Keep Laravel-

### `release-marketing-standard.md` — Release e README marketing — Tenant


# Release e README marketing — Tenant

## Scopo

Ogni modulo/tema deve essere pubblicabile, comprensibile e desiderabile: workflow release, changelog automatico e README vetrina.

## File canonici locali

- `../README.md`
- `../.github/workflows/semantic-release.yml`
- `../.releaserc.json`
- `../CHANGELOG.md`

## Confidenza

La configurazione usa semantic-release con Conventional Commits, changelog, GitHub release e commit automatico del changelog.

### `resolution-conflitti.md` — resolution-conflitti



### `resolve-tenant-config-console-debate.md` — GetTenantConfigValueAction - Console Check Debate

# GetTenantConfigValueAction - Console Check Debate

**Status**: 🔥 FURIOUS INTERNAL DEBATE
**Issue**: `runningInConsole()` check breaks tenant functionality
**Filosofia**: DRY + KISS + SOLID + Multi-Tenant Zen

---

## 🔴 Il Problema Critico

Nel file `GetTenantConfigValueAction.php` esisteva questo blocco:

```php
if (app()->runningInConsole()) {
    $default = $_default;
    $res = config($key, $default);
    if (is_numeric($res) || \is_string($res) || \is_array($res) || $res === null) {
        /** @var float|int|string|array<mixed>|null $res */
        return $res;
    }

### `risoluzione-conflitti.md` — Risoluzione Conflitti nel Modulo Tenant

# Risoluzione Conflitti nel Modulo Tenant

Questo documento descrive i conflitti Git risolti nel modulo Tenant, con particolare attenzione ai file critici e alle strutture di namespace.

> Per una panoramica completa della risoluzione dei conflitti in tutto il progetto, consulta il [documento principale sulla risoluzione dei conflitti](/docs/conflict_resolution_ui_tenant.md).

## Panoramica

Questo documento traccia la risoluzione dei conflitti git nel modulo Tenant, identificati il 30/07/2023.
I conflitti sono stati identificati nei seguenti file:

1. `rector.php`
2. `app/Filament/Resources/DomainResource.php`
3. `app/Filament/Resources/DomainResource/Pages/CreateDomain.php`
4. `app/Filament/Resources/DomainResource/Pages/EditDomain.php`
5. `app/Models/Domain.php`
6. `app/Models/Traits/Su

### `roadmap/05-risks.md` — Risks - Tenant

# Risks - Tenant

## Top Risks

1. Drift tra documentazione e comportamento runtime.
2. Regressioni introdotte da fix rapidi non verificati.
3. Dipendenze incrociate non documentate.

## Mitigations

1. Aggiornare docs insieme ai fix di codice.
2. Usare checklist pre-merge e post-fix.
3. Mantenere un set di file canonici per diagnosi rapida.

### `roadmap/chaos-readiness.md` — Tenant Chaos Readiness - 2026-03-02

# Tenant Chaos Readiness - 2026-03-02

## Scope
- Bootstrap resilience under partial module discovery.

## Completed
- Hardened morph map registration to skip invalid class references safely.
- Verified `Modules/Tenant` passes PHPStan.

## Next Chaos Steps
- Inject broken morph map entries and verify non-blocking boot.
- Add tests for tenant config loading with missing module contracts.

### `roadmap/current-state.md` — Current State - Tenant

# Current State - Tenant

## Baseline

- Stato attuale documentato nei file `docs/` del Modulo.
- Presenza di roadmap strutturata in sotto-file.
- Necessita verifica periodica di coerenza tra codice e documentazione.

## Immediate checks

1. Coerenza tra regole architetturali e implementazione runtime.
2. Coerenza tra naming, namespace e percorsi view/traduzioni.
3. Copertura test minima per i flussi critici.

### `roadmap/documentation-consolidation.md` — Consolidamento documentazione

# Consolidamento documentazione

## Obiettivo

Ridurre duplicazioni, normalizzare i nomi e mantenere i link aggiornati.

## Passi operativi

1. Identificare duplicati con suffissi e varianti.
2. Consolidare contenuti sovrapposti in un unico file.
3. Normalizzare naming in kebab-case.
4. Aggiornare i link interni con percorsi relativi.
5. Archiviare i documenti storici necessari.

## Criticita

- Duplicati con contenuti parzialmente diversi.
- Link obsoleti dopo rinomina.

## Punti di forza

### `roadmap/goals.md` — Goals - Tenant

# Goals - Tenant

## Short Term

1. Allineare documentazione e stato reale del codice.
2. Ridurre i punti di fragilita piu frequenti.
3. Consolidare checklist operative per incident response.

## Medium Term

1. Aumentare test di regressione sui flussi critici.
2. Migliorare osservabilita e diagnosi errori.
3. Ridurre duplicazioni tra documenti e tra componenti.

## Long Term

1. Stabilita sotto fault randomizzati (chaos testing).
2. Manutenibilita alta con onboarding rapido.

### `roadmap/later.md` — Later (Module Tenant)

# Later (Module Tenant)

## Longer-term ideas

### `roadmap/legacy-roadmap.md` — Roadmap Modulo Tenant - Completamento e Miglioramenti

# Roadmap Modulo Tenant - Completamento e Miglioramenti

**Data Creazione**: 2026-01-02
**Status**: 📋 IN LAVORAZIONE
**Versione**: 1.0.0

## 🎯 Obiettivo

Completare il modulo Tenant con tutti i modelli mancanti, migliorare qualità e performance, e garantire isolamento perfetto tra tenant.

## 📊 Stato Attuale

### Metriche
- **File PHP**: 91
- **Test**: 10 (alcuni skipped)
- **Documentazione**: 172 file
- **PHPStan Level 10**: ✅ 0 errori
- **Models**: 14
- **Filament Resources**: 5
- **Actions**: 13

### `roadmap/milestones.md` — Milestones - Tenant

# Milestones - Tenant

## M1 Documentation Baseline

- `roadmap.md` allineato e `docs/roadmap/` completo.
- Link relativi verificati.

## M2 Operational Readiness

- Checklist incident response disponibile.
- Procedure di recovery validate sui casi principali.

## M3 Regression Safety

- Test minimi sui flussi critici in esecuzione regolare.
- Riduzione regressioni ricorrenti.

### `roadmap/missing-models.md` — Modelli mancanti e completamento schema

# Modelli mancanti e completamento schema

## Obiettivo

Completare i modelli mancanti e garantire coerenza tra schema, factory e seeder.

## Passi operativi

1. Inventariare i modelli attesi e mancanti.
2. Allineare migrazioni e naming delle tabelle.
3. Creare factory e seeder minimi.
4. Aggiornare la documentazione dei modelli.
5. Aggiungere test di base per ogni modello nuovo.

## Criticita

- Tabelle con naming non uniforme.
- Modelli legacy senza factory.

## Punti di forza

### `roadmap/next.md` — Next (Module Tenant)

# Next (Module Tenant)

## Features

## Refactors

### `roadmap/now.md` — Now (Module Tenant)

# Now (Module Tenant)

## Stabilization

## Bugfixes

## Quality gates

### `roadmap/overview.md` — Roadmap overview (Module Tenant)

# Roadmap overview (Module Tenant)

## Scope

## Goals

## Non-goals

### `roadmap/performance-optimization.md` — Performance e ottimizzazioni

# Performance e ottimizzazioni

## Obiettivo

Ridurre i tempi di bootstrap tenant e ottimizzare le query critiche.

## Passi operativi

1. Identificare i colli di bottiglia di bootstrap.
2. Ottimizzare le query principali con eager loading.
3. Definire strategie di caching per tenant.
4. Misurare i tempi di risposta prima/dopo.
5. Documentare linee guida di performance.

## Criticita

- Query ripetute in fase di bootstrap.
- Cache condivise senza separazione tenant.

## Punti di forza

### `roadmap/phases.md` — Fasi di sviluppo - Tenant Module

# Fasi di sviluppo - Tenant Module

## Fase 1: Stabilità e Standard (In Corso)

- [x] PHPStan Level 10 Compliance
- [ ] Implementazione del **Cluster Tenant** per l'amministrazione centralizzata
- [ ] Rimozione sistematica dei file obsoleti e pulizia dei docs vuoti
- [ ] Supporto completo per i Service Provider di Laravel 13 nella risoluzione dei tenant

## Fase 2: Onboarding Dinamico (Pianificato)

- [ ] Creazione di un Wizard in Filament per la configurazione semplificata dei nuovi Tenant
- [ ] Automazione delle migrazioni specifiche e isolamento del database
- [ ] Integrazione con Cloud Storage per l'isolamento degli asset multimediali

## Fase 3: Performance e AI (Futuro)

- [ ] **AI-Based Resource Allocation**: Ottimizzazione automatica delle risorse database in base all'uso dei Tenan

### `roadmap/q4-roadmap.md` — Tenant Module Roadmap (2025 Q4)

# Tenant Module Roadmap (2025 Q4)

## Vision & Scope
- Multi-tenant foundation integrated with User, UI, CMS, and Xot.

## Key Outcomes
- Contracts for tenancy stable (teams/tenants)
- 0 PHPStan errors

## Milestones
- [ ] Verify `HasTenants` implementations across modules
- [ ] Ensure BelongsTo/BelongsToMany signatures match contracts
- [ ] Seeders/factories for tenant scenarios

## Acceptance Criteria
- Tenancy works in tests (policies, scoping)
# Tenant Module Roadmap (2025 Q4)

## Vision & Scope
- Multi-tenant foundation integrated with User, UI, CMS, and Xot.

### `roadmap/quality.md` — Checklist qualità - Tenant Module

# Checklist qualità - Tenant Module

- [x] PHPStan Level 10
- [ ] Isolamento dei dati verificato tramite test unitari e di integrazione
- [ ] Assenza di dipendenze circolari tra il modulo Tenant e il resto del sistema
- [ ] Documentazione agnostica aggiornata in `docs/`

### `roadmap/risks.md` — Risks and dependencies (Module Tenant)

# Risks and dependencies (Module Tenant)

## Risks

## Dependencies

### `roadmap/tenant-isolation.md` — Isolamento tenant e configurazioni

# Isolamento tenant e configurazioni

## Obiettivo

Garantire isolamento completo tra tenant in configurazioni, dati e risorse.

## Passi operativi

1. Mappare i punti di inizializzazione tenant.
2. Verificare le configurazioni per tenant.
3. Validare l'isolamento su routing e storage.
4. Documentare i punti di integrazione con altri moduli.
5. Aggiungere test di isolamento per i flussi principali.

## Criticita

- Configurazioni condivise non isolate.
- Uso di cache senza namespace tenant.

## Punti di forza

### `roadmap/test-coverage.md` — Test skipped e copertura critica

# Test skipped e copertura critica

## Obiettivo

Rimuovere i test skipped e aumentare la copertura sulle logiche core del modulo.

## Passi operativi

1. Inventariare i test skipped e i motivi.
2. Sistemare dipendenze e fixture mancanti.
3. Aggiungere test per logiche di isolamento tenant.
4. Coprire i flussi di configurazione e bootstrap.
5. Verificare copertura con focus su casi limite.

## Criticita

- Test che dipendono da modelli non presenti.
- Mancanza di dataset coerenti.

## Punti di forza

### `roadmap/vision.md` — Visione - Tenant Module

# Visione - Tenant Module

Rendere la scalabilità dell'isolamento dei dati un processo immediato e trasparente, permettendo l'onboarding di nuovi tenant in pochi secondi tramite:

- Configurazioni dinamiche
- Automazione delle infrastrutture

### `roadmap/workstreams.md` — Workstreams - Tenant

# Workstreams - Tenant

## WS1 Architecture

- Verifica confini e responsabilita dei componenti.
- Aggiornamento pattern e guardrail.

## WS2 Reliability

- Hardening dei flussi principali.
- Miglioramento fallback e recovery path.

## WS3 Documentation

- Consolidamento documenti canonici.
- Eliminazione drift documentale.

## WS4 Testing

- Test funzionali mirati sui percorsi ad alto rischio.

### `roadmap-miglioramenti.md` — Tenant — cosa migliorerei se questo modulo fosse mio per un mese


# Tenant — cosa migliorerei se questo modulo fosse mio per un mese

> I numeri misurati sono in [`docs/cosa-migliorare.md`](cosa-migliorare.md),
> rilevati da un'altra sessione il 2026-09-01: PHPStan 0, PHPMD `app/` **4 —
> il più basso dei cinque moduli qui analizzati**, Code 91.8, Arch 85.7, 173
> casi test. Questo file non rimisura: legge quei numeri e ci mette sopra la
> lente. Nota: PHPMD gira già (a livello di progetto, senza bisogno di
> config locale) e trova pochissimo — è la certificazione PHPStan
> STANDALONE del modulo, quella bloccata dal `phpstan.neon` mancante di cui
> parlo sotto, non "tutti gli esami".

Questo è il modulo più onesto del monorepo, nel senso peggiore possibile:
`require` vuoto, `require-dev` vuoto, nessun `phpstan.neon`. Zero
`dd()`/`dddx()`, zero `@phpstan

### `roadmap-renamed.md` — 🎯 TENANT MODULE - ROADMAP 2025


# 🎯 TENANT MODULE - ROADMAP 2025

**Modulo**: Tenant ([Description])  
**Status**: 0% COMPLETATO  
**Priority**: LOW  
**PHPStan**: 🚧 Level 0 (N/A errori)  
**Filament**: 🚧 4.x Compatibile  

---

title: "roadmap renamed"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "roadmap renamed"
issues: []
discussions: []
## 🎯 MODULE OVERVIEW

### `rules-index.md` — Rules Index

# Rules Index

This module follows the global Laraxot coding standards.

- [Coding Standards](../../../../docs/laraxot-coding-standards.md)
- [Chaos Monkey Tenant Isolation Checklist](./chaos-monkey-tenant-isolation-checklist.md)
- [Package Dependency Chaos Map](./package-dependency-chaos-map.md)

### `rules-testing-no-migrate-fresh.md` — CRITICAL ARCHITECTURE RULE: NO MIGRATE:FRESH

# CRITICAL ARCHITECTURE RULE: NO MIGRATE:FRESH

## Rule
**NEVER** use `migrate:fresh` or the `RefreshDatabase` trait in any test or setup script within this modular architecture (Laraxot).

## Why?
1. **Destructive**: It destroys all tables across the default database connection.
2. **Tenant/Module Coupling**: In a modular application, tables are meant to be isolated. Wiping the entire database crashes other concurrently running tests or removes shared look-up tables that are not seeded correctly per-module.
3. **Data Loss**: Running tests with `RefreshDatabase` against a shared testing database will indiscriminately destroy other modules' data.

## Correct Approach
- Only use `DatabaseTransactions` to rollback state after tests.
- Maintain strict database boundaries.

### `schema.md` — Tenant Module Schema


# Tenant Module Schema

> **Purpose:** Defines folder rules, frontmatter standards, and workflows for AI agents.

## Module Identity

- **Name:** Tenant
- **Type:** Laravel Module (Laraxot)
- **Location:** `laravel/Modules/Tenant/`
- **Docs:** `laravel/Modules/Tenant/docs/`

## Wiki Rules

### raw/ Rules
- ✅ Immutable — AI reads but never modifies or deletes
- ✅ Drop liberally — articles, code snippets, decisions
- ✅ Subdivide by type: `articles/`, `papers/`, `code-examples/`, `decisions/`

### wiki/ Rules

### `scopo.md` — Tenant — scopo, confini e come servirlo meglio


# Tenant — scopo, confini e come servirlo meglio

## Lo scopo, dedotto dal codice

Il README di questo modulo promette isolamento dei dati per tenant, subscription e
routing multi-dominio. Il codice fa un'altra cosa, più piccola e più critica:
**decide quale configurazione esiste, prima che esista l'applicazione.**

La catena è leggibile in tre file.

1. `app/Actions/GetTenantNameAction.php:23-32` prende `SERVER_NAME`, ne inverte i
   segmenti (`ptvx.local` → `local/ptvx`) e verifica con `file_exists()` che esista
   la cartella `config_path('local/ptvx')`. Non interroga il database: non può, il
   database non è ancora configurato. La riga 98 lo dice esplicitamente —
   *«Durante LoadConfiguration le facade non sono ancora disponibili — usare getenv»*.
2. Quella cartella esiste davvero: 

### `second-brain.md` — Second brain (modulo)


# Second brain (modulo)

Stub **puntatore**: disciplina e link esterni curati stanno nella wiki di progetto.

| Strato | Dove in questo package |
|--------|-------------------------|
| Input / note grezze | questa cartella `docs/` (escluso `docs/wiki/`) |
| Wiki compilata | `docs/wiki/` del modulo |
| Regole globali | wiki root del monorepo |

## Link operativi (relativi al repo)

- Modello: [../../../../bashscripts/ai/wiki/concepts/second-brain-llm-wiki.md#second-brain-operating-model](../../../../bashscripts/ai/wiki/concepts/second-brain-llm-wiki.md#second-brain-operating-model)
- Guida wiki modulo: [../../../../bashscripts/ai/wiki/how-to/wiki-qmd-search.md#module-wiki-documentation](../../../../bashscripts/ai/wiki/how-to/wiki-qmd-search.md#module-wiki-documentation)
- Benchmark lettura

### `services-config-dead-code-retired.md` — Services/Config retired — usare Actions

# Services/Config retired — usare Actions

`Modules/Tenant/app/Services/Config/` (4 file: `ConfigStringKeyFilter.php` + 3 resolver in `Resolvers/`) e' stato archiviato in `Modules/Tenant/docs/archive/Services.old/` (2026-07-14). Era layer Services vietato dalla regola non negoziabile del progetto (Services → Actions), e referenziava anche 3 classi già cancellate da un agente precedente senza `git rm` (`TenantService.php`, `Config/ConfigResolverRegistry.php`, `Config/Contracts/ConfigResolverInterface.php`), causando `Internal error: Could not read file` in PHPStan.

## Sostituzione

| Vecchio (rimosso) | Nuovo (Action, `execute()`) |
|---|---|
| `Tenant\Services\TenantService::getConfig($key)` | `app(\Modules\Tenant\Actions\Config\GetTenantConfigArrayAction::class)->execute($key)` |
| `Tena

### `services.md` — services



### `session-learnings-modules-config.md` — Lezioni 2026-07-27 — moduli, tenant, config


# Lezioni 2026-07-27 — moduli, tenant, config

Hub sintetico per agenti: cosa è successo, perché, dove documentare.

## 1. `modules_statuses.json` tenant workorder

**Problema:** `config/local/workorder/modules_statuses.json` stale (altro progetto) + `modules.php` non puntava al file tenant.

**Fix:** 38 moduli con `module.json` → tutti `true`; rimossi fantasma (`DbForge`, `FormBuilder`, nomi legacy multi-verticale).

**SSoT fisico:** solo directory con `Modules/{Name}/module.json`.

**Doc:** [tenant-module-status-registry.md](./tenant-module-status-registry.md) · [it/config/modules-statuses.md](./it/config/modules-statuses.md) · [WorkOrder/modules-statuses-workorder.md](../WorkOrder/docs/modules-statuses-workorder.md)

## 2. `config/config.php` per modulo

**Problema:** 21 moduli senza m

### `social.md` — social



### `stories/0001-tenant-phpstan-fix.story.md` — BMAD Story - Tenant PHPStan Fix

# BMAD Story - Tenant PHPStan Fix

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0002-tenant-skippedtestexception-non-esiste-piu.story.md` — Story 2.14 — Gli skip di Tenant lanciano una classe che non esiste

# Story 2.14 — Gli skip di Tenant lanciano una classe che non esiste

## Context and Problem Statement

Nella corsa del 2026-08-24 il modulo Tenant ha 73 errori, e i primi 20 sono tutti la stessa
riga ripetuta:

```
class.notFound   Instantiated class PHPUnit\Framework\SkippedTestException not found.
class.notFound   Throwing object of an unknown class PHPUnit\Framework\SkippedTestException.
```

**Non è un falso positivo.** In `vendor/phpunit/phpunit/src/Framework/Exception/Skipped/`
esistono tre classi — `SkippedTest` (interfaccia), `SkippedTestSuiteError`,
`SkippedWithMessageException` — e `SkippedTestException` non è fra queste. Il progetto gira su
**PHPUnit 13.3.0**; quel nome apparteneva a PHPUnit ≤ 9.

Quindi le dieci occorrenze non saltano niente: quando il ramo viene preso, PHP so

### `stories/0003-multi-tenant-scope-isolation.story.md` — 3.5: Multi-tenant scope isolation (tenant_id in queries)

# 3.5: Multi-tenant scope isolation (tenant_id in queries)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0004-verify-rls-policies.story.md` — 3.8: Row-Level Security: verify RLS policies active

# 3.8: Row-Level Security: verify RLS policies active

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0005-monitoring-alerting-setup.story.md` — 5.8: Monitoring setup: Vercel logs + alerting on errors

# 5.8: Monitoring setup: Vercel logs + alerting on errors

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0006-setup-wizard-db-init-seed.story.md` — 6.1: Filament setup wizard: DB init + seed

# 6.1: Filament setup wizard: DB init + seed

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0012-docs-index-audit.story.md` — Tenant: audit e riorganizzazione indice docs/

# Tenant: audit e riorganizzazione indice docs/

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0013-git-state-conflict-marker-daemon-cleanup.story.md` — Tenant — pulizia stato git (marker di conflitto residui)

# Tenant — pulizia stato git (marker di conflitto residui)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0014-phpstan-safe-preg-stringable.story.md` — PHPStan: Safe\preg_replace e stringhe

# PHPStan: Safe\preg_replace e stringhe

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0015-phpstan-tenant-swarm-scope-fix.story.md` — PHPStan swarm — perimetro Tenant: scope, causa radice, fix

# PHPStan swarm — perimetro Tenant: scope, causa radice, fix

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0016-phpstan-test-wave-tenant.story.md` — Tenant: regressione PHPStan dei test dopo il pull del 2026-10-20

# Tenant: regressione PHPStan dei test dopo il pull del 2026-10-20

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0017-placeholder-translations-cleanup.story.md` — Via le traduzioni segnaposto dai file di lingua

# Via le traduzioni segnaposto dai file di lingua

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `structure.md` — structure



### `sushi-traits-phpstan-fixes.md` — Correzioni Trait Sushi - PHPStan Level 10

# Correzioni Trait Sushi - PHPStan Level 10

## Obiettivo

Correggere i trait `SushiToJsons` e `SushiToJson` per eliminare ~85 errori PHPStan distribuiti su tutti i modelli che li usano.

## Trait Corretti

### 1. SushiToJsons.php (~70 errori → 0)

**Pattern problema**: `$model` generic in closure senza type hints

**Errori risolti**:
- `property.notFound`: Access to undefined property `$id`, `$updated_at`, `$created_at`, `$created_by`, `$updated_by`
- `method.notFound`: Call to undefined method `getJsonFile()`
- `argument.type`: Parameters per `File::json()`, `File::put()`, `dirname()`, `unlink()`

**Soluzione applicata**:
```php
// PRIMA: Accesso diretto properties

### `task-consolidare-documentazione.md` — Task: Consolidare Documentazione - Tenant

# Task: Consolidare Documentazione - Tenant

**Modulo**: Tenant
**Priorita'**: Bassa
**Completamento**: 30%

---

## Criteri di Completamento

- [ ] Rimossi duplicati da 90 docs
- [ ] README.md aggiornato

### `task-ridurre-phpstan-test.md` — Task: Ridurre Suppressioni PHPStan nei Test - Tenant

# Task: Ridurre Suppressioni PHPStan nei Test - Tenant

**Modulo**: Tenant
**Priorita'**: Media
**Completamento**: 0%

---

## Descrizione

73 suppressioni in `tests/Unit/SushiToJsonTraitTest.php`. Problemi Pest/PHPStan integration.

## Criteri di Completamento

- [ ] Analizzate tutte le 73 suppressioni
- [ ] Risolte quelle non dovute a limiti Pest

### `task-test-isolamento-dati.md` — Task: Test Isolamento Dati - Tenant

# Task: Test Isolamento Dati - Tenant

**Modulo**: Tenant
**Priorita'**: Media
**Completamento**: 30%

---

## Test da Implementare

- [ ] Isolamento query tra tenant diversi
- [ ] Context switching tra tenant
- [ ] Configurazione tenant-specific
- [ ] Policies tenant-aware

## Criteri di Completamento

- [ ] 6+ test isolamento dati
- [ ] Test context switching

### `tasks/multi-tenancy-system.md` — Task 001: Implement Multi-Tenancy System

# Task 001: Implement Multi-Tenancy System

## Description
Create comprehensive multi-tenancy system with tenant isolation, onboarding, resource allocation, and billing management.

## Context
The Tenant module needs robust multi-tenancy support for serving multiple customers/organizations with complete data isolation and resource management.

## Requirements

### Functional Requirements
- Tenant isolation (database, files, cache)
- Tenant onboarding workflow
- Resource allocation and limits
- Tenant billing and subscriptions
- Tenant management dashboard
- Subdomain/Domain management
- Tenant customization (logo, theme)
- Tenant analytics and monitoring
- Tenant migration and backup

### `tenant-module-status-registry.md` — Registro tenant-specific dei moduli abilitati


# Registro tenant-specific dei moduli abilitati

## Due registri distinti — non confonderli

Questo progetto ha **due meccanismi separati** che controllano/descrivono i moduli, e per
molto tempo in questa sessione multi-agente solo il primo è stato auditato:

| Meccanismo | File | Letto da | Scopo |
|---|---|---|---|
| **nwidart FileActivator** (root) | `modules_statuses.json` (root Laravel) | `config/modules.php` → `activators.file.statuses-file` | Abilita/disabilita il **boot** del modulo a livello framework (autoload, service provider, migrations, ecc.) |
| **Panel metadata per-modulo** | `Modules/{Name}/config/config.php` | `XotBaseServiceProvider::registerConfig()` → `PanelMixin` | `name`/`icon`/`navigation.sort` per il pannello Filament di quel modulo |
| **Tenant module registry** 

### `tenant-name-to-pub-theme.md` — Dal nome tenant al tema pubblico (pub_theme)

# Dal nome tenant al tema pubblico (pub_theme)

La **risoluzione del tema** dipende dal modulo Tenant: il nome tenant determina la cartella di config da cui si legge `xra.php` e quindi `pub_theme`.

## Catena

1. **`APP_URL`** (`.env`) → es. `http://<nome progetto>.local`
2. **`GetTenantNameAction::execute()`** → ricava l’host da `config('app.url')` (o `$_SERVER['SERVER_NAME']`), inverte le parti (es. `<nome progetto>.local` → `local/<nome progetto>`)
3. **Cartella config** → `config_path($tenantName)` = `laravel/config/local/<nome progetto>/`
4. **`TenantService::getConfig('xra')`** → carica `config/local/<nome progetto>/xra.php`
5. **`pub_theme`** → in `xra.php` la chiave `pub_theme` (es. `'Meetup'`) identifica il tema pubblico
6. **Percorso tema** → `laravel/Themes/{pub_theme}` (es. `la

### `tenant.md` — tenant

https://gist.github.com/nathandaly/44a83df5e3ea735eae91652c7a4894c9

### `test1.md` — test1



### `testing-rules.md` — Testing Rules Summary

# Testing Rules Summary

## Regole Fondamentali dei Test

### 1. **Pest Testing Mandatory**
- **MAI** usare PHPUnit class-based (`class Test extends TestCase`)
- **SEMPRE** usare Pest functional syntax (`test()`, `it()`)
- I test devono essere scritti in formato Pest, non PHPUnit

### 2. **NO RefreshDatabase - MAI**
- **MAI** usare `use RefreshDatabase` nei test
- **MAI** usare `RefreshDatabase` trait
- Utilizzare `.env.testing` con SQLite in-memory
- Usare `DatabaseTransactions` se necessario (raro)

### 3. **Configurazione Testing**
- Tutti i test devono leggere `.env.testing`
- PHPStan usa configurazione da `phpstan.neon` (non passare livello come parametro)
- Script di conversione vanno in `bashscripts/`, non nella root di Laravel


### `testing-sushitojson-integration-fix.md` — Fix: SushiToJsonIntegrationTest - Database Connection Configuration

# Fix: SushiToJsonIntegrationTest - Database Connection Configuration

**Problema**: Test fallisce con "Database connection [tenant] not configured"
**Principio**: Il sito funziona, quindi il test deve essere corretto per riflettere il comportamento reale

## 🔍 Analisi del Problema

### Errore Originale
```
InvalidArgumentException: Database connection [tenant] not configured.
```

### Causa
- Il modello `Tenant` estende `BaseModel` che ha `protected $connection = 'tenant'`
- Il test `SushiToJsonIntegrationTest` non configura la connessione 'tenant' nel setUp()
- Il test estende `Tests\TestCase` che non configura automaticamente la connessione 'tenant'

### Confronto con Test Funzionanti
- `TenantBusinessLogicTest` funziona e usa `Tenant::factory()->create()`
- `TenantBusinessLogicTest` es

### `testing.md` — Testing Documentation

# Testing Documentation

## Stories PHPStan attive

- [TENANT-7.1 — boundary Sushi](stories/0007-phpstan-sushi-boundaries.story.md) possiede
  trait, Action e consumer domain.
- [TENANT-7.2 — contratti dei test harness](stories/0008-phpstan-test-harness-contracts.story.md)
  possiede i 40 findings residui nei test di configurazione, Sushi e coverage.

### Esito TENANT-7.2

La baseline cold di 40 findings è stata portata a zero. Config e resolver vengono ristretti
prima degli offset, le fixture Sushi dichiarano value types reali, le funzioni fallibili
usano `Safe\` e gli attributi Eloquent passano da `setAttribute()`/`getAttribute()`.

Disposition: **75 test mantenuti, 0 file test cancellati**. La tautologia sull'ID Sushi è
diventata un'asserzione sull'ID realmente assegnato; input impossib

### `to-integrate.md` — to-integrate

https://filamentphp.com/plugins/andrew-wallo-companies

### `todo.md` — Tenant Module - PHPStan Error Resolution Roadmap

# Tenant Module - PHPStan Error Resolution Roadmap

This document outlines the steps to resolve the numerous PHPStan errors found in the Tenant module.

## Error Summary

The errors in the Tenant module are widespread and primarily stem from a few core issues:

1.  **Improper Model Instantiation in Tests**: Models are not being created with the correct factories or types, leading to a massive number of errors where methods and properties are accessed on `mixed` types.
2.  **Unsafe JSON Functions**: `json_decode` and `json_encode` are used without the `thecodingmachine/safe` library, which can lead to unexpected `false` return values.
3.  **PHPUnit to Pest Conversion Issues**: Many tests appear to be partially converted from PHPUnit to Pest, resulting in undefined properties and methods (e.

### `translations.md` — Traduzioni del Modulo Tenant

# Traduzioni del Modulo Tenant

## Collegamenti

- [Modulo Lang](../../lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../xot/docs/translations.md)

## Struttura

```
Modules/Tenant/
└── lang/
    ├── it/
    │   └── tenant.php
    └── en/
        └── tenant.php
```

## Contenuto


### `troubleshooting.md` — Tenant Module Troubleshooting Guide


# Tenant Module Troubleshooting Guide

**Last updated: 2026-07-28**

This guide addresses common issues, errors, and scenarios in the Tenant module.

---

## 1. Isolation Failures

### Error Pattern
Data from different tenants appearing in queries, or users accessing data from other tenants.

### Possible Causes
- Missing global scope on model
- Middleware not established tenant context
- Query uses `withoutGlobalScopes()`
- Direct database query bypassing Eloquent
- Trait not applied to model

### `updates-dec.md` — Tenant Module Updates - December 2025

# Tenant Module Updates - December 2025

## PHPStan Fixes
- **DocBlock Updates**: Fixed `class.notFound` errors in `Tenant`, `Domain`, and `TestSushiModel` by replacing incorrect `modulo operativo` and `modulo questionari` profile references with `Modules\Xot\Contracts\ProfileContract`.
- **Helper Functions**: Added `getAllModulesModels` and `array_merge_recursive_distinct` to `Modules/Xot/helpers/Helper.php` to resolve undefined function errors.
- **TenantService Refactor**: Adhering to the "Fat Model, Skinny Controller" (and Service) philosophy, all business logic has been extracted into dedicated Action classes:
    - `GetTenantFilePathAction`
    - `GetTenantConfigValueAction`
    - `GetTenantConfigPathAction`
    - `GetTenantConfigArrayAction`
    - `SaveTenantConfigAction`
    - `Get

### `updates.md` — Tenant Module Updates - December 2025

# Tenant Module Updates - December 2025

## PHPStan Fixes
- **DocBlock Updates**: Fixed `class.notFound` errors in `Tenant`, `Domain`, and `TestSushiModel` by replacing incorrect `modulo operativo` and `<nome progetto>` profile references with `Modules\Xot\Contracts\ProfileContract`.
- **Helper Functions**: Added `getAllModulesModels` and `array_merge_recursive_distinct` to `Modules/Xot/helpers/Helper.php` to resolve undefined function errors.
- **TenantService Refactor**: Adhering to the "Fat Model, Skinny Controller" (and Service) philosophy, all business logic has been extracted into dedicated Action classes:
    - `GetTenantFilePathAction`
    - `GetTenantConfigValueAction`
    - `GetTenantConfigPathAction`
    - `GetTenantConfigArrayAction`
    - `SaveTenantConfigAction`
    - `GetTen

### `user-interface.md` — user-interface
