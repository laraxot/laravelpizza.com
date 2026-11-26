---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 65 file oltre target 100.

### `00-index.md` — 📚 RATING Module - Documentation Index

# 📚 RATING Module - Documentation Index

**Path**: `laravel/Modules/Rating/docs/`  
**Modulo**: @Modules/Rating

## 📄 Documenti

### Product
| File | Scopo |
|------|-------|
| PRD.md | Product Requirements |
| product-roadmap-2.md | Roadmap |
| product-strategy-2.md | Strategy |
| product-launch-plan-2.md | Launch Plan |

### Development
| File | Scopo |
|------|-------|
| gsd-workflow-2.md | GSD Workflow |
| sprint-planning-2.md | Sprint Planning |

### `agent-edit-discipline.md` — agent-edit-discipline


See canonical documentation: ../../../Themes/docs/shared-components/agent-edit-discipline-Modules.md

### `architecture-rules.md` — Architectural Rules & Guidelines

# Architectural Rules & Guidelines

This module adheres to the **Laraxot Architecture** and **Super Cow Methodology**.

For strict coding standards, Filament extension rules, and PHPStan guidelines, please refer to the central documentation in the **Xot Module**:

-   [Super Cow Methodology](../../Xot/docs/super_cow_methodology.md)
-   [PHP Quality Guide](../../Xot/docs/php_quality_guide.md)
-   [Filament Extension Rules](../../Xot/docs/filament-extension-rules-2.md)

**Key Principles:**
1.  **DRY & KISS**: Don't repeat yourself, keep it simple.
2.  **Zero Errors**: PHPStan Level 10 compliance is mandatory.
3.  **XotBase**: Always extend `XotBase` classes, never Filament classes directly.
4.  **Translations**: Use `LangServiceProvider` for automatic label resolution.

### `bad-practices.md` — Bad Practices – Rating

# Bad Practices – Rating

## ❌ Calcolare la media in query N+1
Usa `withAvg()` Eloquent per aggregazioni efficienti.

## ❌ Usare float per star_rating
Genera problemi di UI e formattazione; usa interi 1-5.

## ❌ Consentire rating duplicati senza validazione
Implementa `unique:ratings,user_id,rateable_id`.

### `best-practices-2.md` — Best Practices – Rating

# Best Practices – Rating

## Principi DRY/KISS
- **DRY**: Centralizza logica di scoring in `RatingService`. Usa attributi calcolati per azioni utente.
- **KISS**: Usa `star_rating` come integer 1-5, non float o stringhe.
- **Clean Code**: Segui il pattern `Builder` per recensioni complesse.

## Componenti
- Usa `RatingStar` per visualizzare icone vuote/piene.
- Usa `AverageRating` come campo calcolato (non memorizzato).

## Test
- Implementa test unitari per `RatingService::calculate()`.
- Copri casi limite come rating inversi.

## Documentazione
- Aggiorna `docs/index-2.md` con nuovi endpoint.
- Collega a moduli correlati come `Review` e `Auth`.

### `bmad/stories/0081-rating-contract-template-binding.story.md` — Specificare il template del contratto Rating

# Specificare il template del contratto Rating

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


### `bmad/stories/0085-rating-morphs-sti-parent-fqcn.story.md` — ratingMorphs su figlio STI: alias e FQCN del padre

# ratingMorphs su figlio STI: alias e FQCN del padre

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


### `bmad/stories/0086-rating-phpstan-l10-swarm-level-audit-module-errors.story.md` — Story Rating/phpstan-l10-swarm-2026-10-06

# Story Rating/phpstan-l10-swarm-2026-10-06

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


### `bmad/stories/0087-rating-phpstan-l10-swarm.story.md` — Story Rating/phpstan-l10-swarm-2026-10-06

# Story Rating/phpstan-l10-swarm-2026-10-06

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


### `bmad/stories/0088-rating-query-with-extra-attributes-scope.story.md` — Story: rating-query-with-extra-attributes-scope

# Story: rating-query-with-extra-attributes-scope

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


### `bmad/stories/0089-rating-statics-to-ratingdata-consolidation.story.md` — Story: consolidamento helper statici: trait → `RatingData`

# Story: consolidamento helper statici: trait → `RatingData`

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


### `bmad/stories/0090-rating-table-component-reusable.story.md` — Story: rating-table-component-reusable

# Story: rating-table-component-reusable

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


### `bmad/stories/0092-rating-xls-fields-move-to-ratingdata.story.md` — Story: `ratingXlsFields` → `RatingData::getXlsFields` (mossa reale, no facade)

# Story: `ratingXlsFields` → `RatingData::getXlsFields` (mossa reale, no facade)

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


### `bmad/stories/0093-rating-xls-fields-ratingclass-required.story.md` — Story: `ratingXlsFields`/`RatingData::getXlsFields`: `$ratingClass` required

# Story: `ratingXlsFields`/`RatingData::getXlsFields`: `$ratingClass` required

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


### `bmad/stories/0097-ratingdata-api-restore-after-laraxot-sync.story.md` — ratingdata-api-restore-after-laraxot-sync-2026-09-24

# ratingdata-api-restore-after-laraxot-sync-2026-09-24

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


### `bmad/stories/0098-ratingdata-formfieldlabel-contract.story.md` — BMAD: ratingdata-formfieldlabel-contract

# BMAD: ratingdata-formfieldlabel-contract

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


### `bmad/stories/0099-ratingdata-ratingcontract-typing.story.md` — BMAD: ratingdata-ratingcontract-typing

# BMAD: ratingdata-ratingcontract-typing

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


### `bmad/stories/0101-manuals-screenshots-dashboard-widget.story.md` — Story 0101 — Manuali e dashboard Rating


# Story 0101 — Manuali e dashboard Rating

## Acceptance

- [x] Conflitti `<<<<<<<` risolti preferendo laraxot/dev su Models/Filament/boot
- [x] `docs/manuals/manuale-utente.md` con screenshot reali del pannello
- [x] Dashboard non più Blade vuota: `RatingPanelStatsOverviewWidget`
- [x] Modulo abilitato in `modules_statuses.json`
- [x] Emoji login tema rimossa (tofu in headless)

## Note

Impostazioni form vuoto = intenzionale (`RatingConfigData`). Screenshot lista
catturati autenticati; dashboard dipende da sessione/APP_URL host.

### `bmad/stories/0102-phpstan-trait-unused-anchors.story.md` — Story 0102 — trait.unused → anchor


# Story 0102 — trait.unused → anchor

## Perché

`phpstan analyse Modules` segnalava 3× `trait.unused` su Rating. I consumer
vivevano solo in `tests/Fixtures` (esclusi da `phpstan.neon`) o in moduli host
assenti in questo tree. Lo scopo dei trait resta API pubblica per host.

## Fix (sorgente)

Stesso pattern di `AbstractRatingsHost`:

- `AbstractHasRatingHost`
- `AbstractLikeableHost`
- `AbstractRatingsFormCaller` (usa `DecoratesRatingFormFields` + contract)

## Verifica

`./vendor/bin/phpstan analyse Modules` → 0 errori.

### `code-quality-analysis.md` — Code Quality Analysis - Rating Module

# Code Quality Analysis - Rating Module

**Data Analisi**: 2025-01-22  
**PHPStan Level**: 10  
**Status**: ✅ PASSING

## 📊 Risultati Analisi

### PHPStan Level 10
- **Errori**: 0
- **Status**: ✅ Perfetto
- **Ultimo Fix**: Risolti errori di type narrowing in `GetSumByModelRatingIdAction.php`

### PHPMD
- **Configurazione**: `phpmd.ruleset.xml` presente nel modulo
- **Status**: Da eseguire

### PHPInsights
- **Configurazione**: Non presente
- **Raccomandazione**: Creare `phpinsights.php` per analisi completa

### `code-redundancy-audit.md` — Code redundancy audit — Rating


# Code redundancy audit — Rating

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo module, senza perdere conoscenza storica.

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 73 |
| Rischio ridondanza | medium |
| Basename duplicati locali | 5 |
| Hash normalizzati duplicati cross-owner | 1 |
| Class/trait/interface name ripetuti nel monorepo | 12 |
| File grandi >=350 righe | 0 |
| File PHP con marker Git | 0 |

## Evidenze

### `codex-error-fix.md` — codex-error-fix


See canonical documentation: ../../../Themes/docs/shared-components/codex-error-fix.md

### `configuration.md` — Rating Module Configuration

# Rating Module Configuration

## `composer.json` Dependencies

The `composer.json` file for the Rating module (`laravel/Modules/Rating/composer.json`) defines its core dependencies and development tools.

### `require` Section

This section lists the essential packages required for the module to function correctly. Adherence to semantic versioning is crucial, typically using caret (`^`) or tilde (`~`) operators to allow for patch and minor updates while preventing breaking changes.

```json
"require": {
    "spatie/laravel-schemaless-attributes": "^3.0",
    "laravel/framework": "^12.0",
    "filament/filament": "^5.0"
}
```

*   `spatie/laravel-schemaless-attributes`: Essential for handling flexible, schemaless data structures within the module's Eloquent models.
*   `laravel/framework`:

### `conflict-resolution.md` — Conflict Resolution — Module Rating

# Conflict Resolution — Module Rating

## Summary
- **Files resolved**: 1
- **Strategy**: Keep HEAD/local (ours) side
- **Root cause**: Nested stash-on-merge conflicts

## Config Files
- composer.json

## Backlinks
- [Root conflict resolution report](../../../../docs/conflict-resolution-report.md)

## Regressioni silenziose del sync del 21/11 (24/11/2026)

`find_sync_regressions.py` (`SYNC_BASE=dd46996a4`) su `Modules/Rating`: 11 `deleted-unseen`, tutti file di strumenti alla
radice del modulo (`.gitmodules`, `.php-cs-fixer*.php`, `.php_cs.dist.php`, `phpmd.ruleset.xml`, `phpstan-baseline.neon`,
`phpstan.neon.dist`, `phpstan_constants.php`, `phpunit.xml.dist`, `webpack.mix.js`, `scripts/ci/contributor-lines-report.mjs`).
Nessuno e' letto dal codice del modulo; non ripristinati (la regola d

### `data-models.md` — data-models


See canonical documentation: ../../../Themes/docs/shared-components/.gitkeep-Modules

### `docs-archive-policy.md` — Docs archive policy

# Docs archive policy

`docs/archive/` is local-only scratch/history and must not be used as a canonical module documentation source.

Active module knowledge belongs in normal `docs/*.md`, `docs/wiki/**`, or a precise topical subdirectory. This keeps QMD ingestion deterministic and prevents stale duplicate notes from being treated as current architecture guidance.

The module `.gitignore` ignores `docs/archive/`; when a useful archived note is still valid, promote it into a live document outside `archive` and link it from the local docs index.

### `dry-kiss-analysis.md` — 🐄 DRY & KISS Analysis - Rating

# 🐄 DRY & KISS Analysis - Rating

**Data:** 2025-10-15 | **Status:** ✅

## 📊 Struttura
Models: 8 | Resources: 2 | Actions: 3 | Docs: 15

## 🎯 Score: 9/10 🟢 **ECCELLENTE**

## ✅ PERFETTO
- BaseModel: GIÀ ottimizzato ⭐
- Minimal & focused ⭐
- Docs minime (15) ⭐

## ⚠️ MIGLIORAMENTI MINIMI
Resources (2): Helpers (~40 LOC)

**Status:** 🟢 **ECCELLENTE**


### `false-friends.md` — False Friends – Rating

# False Friends – Rating

| Falso Amico | Perché è fuorviante | Soluzione |
|-------------|---------------------|-----------|
| `rating_count` = `reviews_count` | Conta anche rating senza testo | Usa `review_count()` distinto |
| `avg(rating)` = `popularity` | Ignora il numero di voti | Normalizza per numero voti |
| 4.5 ⭐ è "ottimo" | Dipende da scala e contesto | Definisci soglie chiare |
| Rating sempre crescente | Non considera il tempo | Usa weighted average |

### `filament-version.md` — Filament Version Declaration — Rating

# Filament Version Declaration — Rating

**Current Version**: Filament v5 (Livewire v4 + Schemas)

This module/theme is developed against **Filament v5**.

All resources, forms, tables, infolists, widgets and actions must follow the v5 + XotBase patterns documented in:

- `docs/wiki/rules/filament-rules-summary.md`
- `docs/wiki/memories/filament-version-policy.md`
- `laravel/Modules/Xot/docs/filament-5-laraxot-rules.md`

**Legacy v4 documents** in this folder (if any) are historical only and must not be used as current reference.

**Last verified**: 2026-05-21

**Firmato:** Cursor Agent (Composer) — template propagato ai package `docs/`

### `file-naming-rules.md` — file-naming-rules


See canonical documentation: ../../../Themes/docs/shared-components/file-naming-rules.md

### `index-2.md` — Documentation Index

# Documentation Index

Modulo: Rating

## File disponibili

<!-- auto-generato: elencare i file .md presenti -->

---

## ⚠️ Architectural Rules

- **[No Http Controllers — Folio + Actions + Filament](../../../../docs/wiki/rules/no-controllers-rule.md)** — Absolute rule: Rating module must NOT use Http\Controllers. Rating HTTP endpoints use Folio + Actions. Admin uses Filament.

### `laravel-13-upgrade.md` — Upgrade Laravel 13 - Rating 🐄✨

# Upgrade Laravel 13 - Rating 🐄✨

## 🎯 Visione Architetturale
L'upgrade a Laravel 13 per il modulo **Rating** non è un mero aggiornamento tecnico, ma un atto di purificazione zen. Seguendo i dettami della **Super Mucca**, ogni riga di codice è stata meditata per raggiungere la massima indipendenza.

## 🧘 Principi Applicati
1.  **Isolamento (SOLID)**: Il modulo dichiara ora esplicitamente le proprie dipendenze, riducendo l'accoppiamento con il core.
2.  **Semplicità (KISS)**: Rimossi i wrapper obsoleti e le dipendenze ridondanti.
3.  **Memoria (Documentation)**: Questo documento funge da memoria persistente dell'evoluzione del modulo.

## 🛠️ Modifiche Eseguite
- [x] **PHP ^8.4**: Allineamento ai requisiti di Laravel 13.
- [x] **composer.json**: Aggiornato con `laravel/framework: ^13.0` e `n

### `launch-plan.md` — Product Launch Plan: Rating Module

# Product Launch Plan: Rating Module

## 🚀 Launch Overview
- **Launch Date:** Q2 2026
- **Launch Lead:** @CoreTeam

## 🎯 Launch Goals
- Deploy stable version of Rating Module.

### `license-2.md` — license-2

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

### `manuals/manuale-utente.md` — Manuale d'uso — Rating


> Screenshot reali del pannello `rating/admin`, catturati il 25 novembre 2026 con
> `bashscripts/tools/docs/manual-screenshots.mjs` su un'istanza di prova isolata
> (tabelle vuote, utente sintetico). Ogni scatto ha data, HTTP, URL e sha256 in
> [`screenshots.json`](screenshots.json). Non si documentano UI inventate.

![Elenco dei criteri di voto](assets/rating-admin-ratings.webp)

# Manuale d'uso — Rating

## Scopo e perimetro

Rating gestisce i **criteri di voto** (`ratings`) e i **collegamenti morph**
(`rating_morph`) verso i modelli valutabili. L'interfaccia operativa è il pannello
Filament `rating/admin`. Non espone pagine pubbliche proprie: il front office è del
tema (Meetup).

## Accesso

1. Aprire `/rating/admin/login`.

### `merge-conflicts-list.md` — merge-conflicts-list


See canonical documentation: ../../../Themes/docs/shared-components/merge-conflicts-list.md

### `on-demand-pattern.md` — On-Demand Pattern — Module **Rating**


# On-Demand Pattern — Module **Rating**

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

### `prd.md` — PRD: Rating Module

# PRD: Rating Module

## 📋 Overview
- **Author:** Gemini CLI
- **Status:** Draft
- **Target Release:** 1.0.0

## ❓ Problem Statement
Specialized logic for Rating needs a dedicated, type-safe Module to ensure maintainability.

## 🎯 Goals & Success Metrics
- **Goal 1:** 100% PHPStan L10 compliance.
- **Goal 2:** Seamless integration with XotBase.

### `product-launch-plan.md` — Rating - Product Launch Plan

# Rating - Product Launch Plan

> Piano di lancio. Modulo.
> Launch readiness stimata: 64%.

## Obiettivo del lancio

Rilasciare **Rating** in modo controllato, misurabile e coerente con il suo ruolo: outcome, rating e segnali di preferenza/mercato.

## Audience interna

- owner di modulo o tema
- admin/operatori
- sviluppatori che dipendono dal componente

## Criteri di readiness

- PRD e roadmap aggiornati
- test critici verdi
- smoke test del runtime completato

### `product-requirements.md` — Product Requirements Document (PRD)

# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **Last Updated** | 2026-03-03 |
| **Owner** | User Team |
| **Module** | Rating |
| **Repository** | laraxot/module_rating_fila5 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo Rating fornisce un sistema per **ratings e valutazioni** con supporto per attributi schemaless. Permette di aggiungere valutazioni a qualsiasi entità.


### `product-roadmap-2.md` — Rating Module - Product Roadmap

# Rating Module - Product Roadmap

**Module:** Rating  
**Version:** 1.0.0  
**Last Updated:** March 12, 2026  
**Owner:** Product Team  
**Status:** In Development

---

## Vision Statement

To create a **comprehensive rating and review system** that builds trust through authentic user feedback, drives quality improvements, and helps users make informed decisions.

### Vision Pillars

1. **Authenticity:** Real, verified user ratings
2. **Trust:** Transparent, fraud-resistant system
3. **Insight:** Actionable feedback for improvement
4. **Engagement:** Easy, rewarding rating experience

### `product-roadmap.md` — Rating - Product Roadmap

# Rating - Product Roadmap

> Documento vivente. Modulo.
> Maturita' stimata: 64% implementato, 36% gap residuo.

## Visione di avanzamento

Questo roadmap traduce il PRD in sequenza di rilascio per **Rating**, che nel progetto copre: outcome, rating e segnali di preferenza/mercato.

## Orizzonte 0-30 giorni

- chiudere i gap P0 descritti in [PRD](prd.md)
- riallineare codice, test e documentazione
- rimuovere le ambiguita' tra stato reale e stato percepito

## Orizzonte 30-90 giorni

- consolidare test, osservabilita' e metriche
- completare le superfici utente o admin critiche
- ridurre le dipendenze manuali o i fallback fragili

### `product-strategy-2.md` — Rating Module - Product Strategy

# Rating Module - Product Strategy

**Module:** Rating  
**Version:** 1.0.0  
**Last Updated:** March 12, 2026  
**Owner:** Product Team

---

## Executive Summary

The Rating module enables authentic user feedback through ratings and reviews, building trust and providing valuable insights for continuous improvement.

---

## Market Analysis

### TAM / SAM / SOM

| Segment | TAM | SAM | SOM (2028) |

### `product-strategy.md` — Rating - Product Strategy

# Rating - Product Strategy

> Strategia prodotto. Modulo.
> Allineamento strategico stimato: 64%.

## Missione

Portare **Rating** a uno stato in cui il progetto ottiene un vantaggio netto e misurabile su questa area: outcome, rating e segnali di preferenza/mercato.

## Problema da risolvere

- chiarire il ruolo del componente nel sistema
- evitare sovrapposizioni con altri moduli o temi
- rendere il valore del componente esplicito e verificabile

## Principi strategici

- DRY: riuso prima di duplicare
- KISS: superfici semplici e veritiere
- truth over demo: nessuna feature solo apparente

### `project-structure.md` — Project Structure — Module **Rating**


# Project Structure — Module **Rating**

## Directory Structure

\`\`\`
./laravel/Modules/Rating/docs/
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
│   │   ├── index-2.md
│   │   └── *.md
│   ├── commands/                 # Comandi progettuali

### `qmd-setup.md` — QMD Setup per Module **Rating**


# QMD Setup per Module **Rating**

## Configurazione QMD per Questo Module

### Collection Configuration

Il progetto usa una collection QMD centralizzata in `.qmd/index.yml` che include tutti i moduli.

### Ricerca Locale vs Globale

**Ricerca locale** (solo questo modulo):
\`\`\`bash
qmd search "<topic>" -c rating
# Cerca solo in ./laravel/Modules/Rating/docs/wiki/
\`\`\`

**Ricerca globale** (tutto il progetto):
\`\`\`bash
qmd search "<topic>"

### `rating-architecture.md` — Rating System - Architecture Analysis & Fixes

# Rating System - Architecture Analysis & Fixes

**Module**: Rating (Agnostic)  
**Context**: IndennitaResponsabilita compilation error  
**Date**: 2026-02-11  
**Status**: Analysis Complete, Implementation Ready

---

## 📋 Current Problem Analysis

### Error Messages in IndennitaResponsabilita
```
The Responsabilità di spesa must be a number.
The Realizzazione piani e programmi must be a number.
The Supporto decisioni del Dirigente must be a number.
The selected tot is invalid.
```

### Root Cause Identified

### `readme-en.md` — ⭐ Rating — English presentation

# ⭐ Rating — English presentation

[![Domain-Rating](https://img.shields.io/badge/Domain-Polymorphic%20Rating-FF6F00.svg)](#)
[![Laravel 12](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com/)
[![Filament 5](https://img.shields.io/badge/Filament-5-ffab00.svg)](https://filamentphp.com/)
[![PHP 8.4+](https://img.shields.io/badge/PHP-8.4+-777BB4.svg)](https://php.net/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PSR-12](https://img.shields.io/badge/Code-PSR--12-blue.svg)](https://www.php-fig.org/psr/psr-12/)
[![Strict Types](https://img.shields.io/badge/PHP-strict__types-1-informational.svg)](#)
[![Laraxot Modules](https://img.shields.io/badge/Architecture-Modular-purple.svg)](#)
[![FixCity Platform](https

### `redundancy-analysis.md` — redundancy-analysis


See canonical documentation: ../../../Themes/docs/shared-components/redundancy-analysis.md

### `redundancy-audit.md` — Rating redundancy audit 2026-05-21


# Rating redundancy audit 2026-05-21

High-risk findings:
- Favorite Livewire views are byte-identical in multiple paths:
  - `resources/views/livewire/favorite2.blade.php`
  - `resources/views/livewire/favorite/favorite2.blade.php`
  - `resources/views/livewire/favorite/streamit.blade.php`
- `favorite.blade.php` and `favorite/default.blade.php` are also byte-identical.
- `admin/dashboard/item.blade.php` is duplicated with `Modules/Fixcity`.
- PHP CS Fixer config files duplicate common module boilerplate.

Risk:
- Livewire view resolution can drift when multiple files imply the same component intent.
- Dashboard item ownership between Rating and Fixcity is unclear.

Suggested cleanup order:
1. Identify Livewire component class/view mapping, then keep only the resolved view.
2. If dashboar

### `redundancy-report.md` — Redundancy Report — Modulo Rating

- Inventario [ridondanze cross-modulo](../docs/redundancy-report.md)
- Concetti [ridondanze cross-cutting](../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md)

# Redundancy Report — Modulo Rating

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Rilevamenti rapidi (scan modulo)

- **Filament:** 2 `*Resource.php` (`RatingResource`, `RatingMorphResource`); nessun nome Resource duplicato a livello root, ma **classi Table gemelle** in `RatingResource/Tables/` (`RatingTable.php` + `RatingsTable.php`) e in `RatingMorphResource/Tables/` (`RatingMorphTable.php` + `RatingMorphsTable.php`) — verificare quale è referenziata e rimuovere l’altra.
- **Widget / RelationManager duplicati:** `StatsOverview` in `Filament/Widgets/` e in `HasRatingResource/Widgets/`; `RatingsRelationManag

### `roadmap/dependencies.md` — Dipendenze e confini del modulo Rating

# Dipendenze e confini del modulo Rating

Relazioni con altri moduli e pacchetti, cosa il modulo **dipende** e da cosa può essere **usato**.

---

## Dipendenze in ingresso (il Rating dipende da)

- **Laravel / Framework**: Laravel 12, Eloquent, migrazioni, container.
- **Xot**: classi base Filament (`XotBaseResource`, `XotBasePage`, …), convenzioni di namespace e traduzioni, eventuale `XotBaseMigration`.
- **Spatie (se in uso)**: es. `spatie/schemaless-attributes` per `extra_attributes` sul modello Rating (vedi [architecture.md](../architecture.md)); versioni allineate al `composer.json` del modulo.
- **Nessun modulo di dominio applicativo**: Rating non deve dipendere da User, Patient, Cms, ecc. per la sua logica core.

---

## Dipendenze in uscita (chi usa il Rating)

- **Moduli consumer

### `roadmap/metrics.md` — Metriche e obiettivi di qualità

# Metriche e obiettivi di qualità

Indicatori misurabili per lo stato del modulo e il successo delle fasi.

---

## Qualità codice

| Metrica | Obiettivo | Come verificare |
|--------|-----------|-----------------|
| PHPStan | 0 errori Level 10 | `./vendor/bin/phpstan analyse Modules/Rating --memory-limit=-1` da `laravel/` |
| Strict types | 100% file PHP | `declare(strict_types=1);` in ogni file |
| Return types | 100% metodi pubblici/protetti | Analisi manuale o PHPStan |
| Estensione base | Tutti i modelli | Ogni modello estende `BaseModel` del modulo |

---

## Test

| Metrica | Obiettivo | Come verificare |

### `roadmap/phases.md` — Fasi di Sviluppo del Modulo Rating

# Fasi di Sviluppo del Modulo Rating

## Fase 1 · Stabilizzazione della base tecnica

### Obiettivi

- Portare il modulo a **PHPStan Level 10** senza errori.
- Allineare tutte le dipendenze e il codice a **Laravel 12** e **Filament v5**.
- Garantire che il modulo sia **sicuro da riutilizzare** in altri progetti Laraxot senza regressioni.

### Attività

- Normalizzare namespace, tipi di ritorno e nullable secondo le regole Laraxot Core.
- Verificare che tutti i modelli del modulo estendano il `BaseModel` corretto del modulo.
- Adeguare eventuali Resource / Widget Filament alle XotBase classes e alle regole:
  - niente `->label()` / `->placeholder()` / `->helperText()`
  - array con **chiavi stringa** per `getTableColumns()`, `getTableFilters()`, `getInfolistSchema()`.
- Aggiungere o corregg

### `roadmap/quality.md` — Checklist Qualità Modulo Rating

# Checklist Qualità Modulo Rating

Questa checklist serve come riferimento operativo per mantenere il modulo `Rating` allineato agli standard Laraxot (PHPStan Level 10, PSR-12, documentazione aggiornata).

## Qualità del codice

- [ ] Tutti i file PHP espongono `declare(strict_types=1);`.
- [ ] Tutte le funzioni e i metodi hanno tipi di ritorno espliciti.
- [ ] Nessun uso di `mixed` se non strettamente necessario (e documentato).
- [ ] Nessun modello estende direttamente `Illuminate\Database\Eloquent\Model` o `Modules\Xot\Models\XotBaseModel`: si usa sempre il `BaseModel` del modulo.
- [ ] Nessun uso di `property_exists()` sui modelli Eloquent.
- [ ] Nessun override di `table()` o di metodi marcati come `final` nelle XotBase classes.

## Static analysis e testing

- [ ] PHPStan Level 10 pe

### `roadmap/vision.md` — Visione del Modulo Rating

# Visione del Modulo Rating

Il modulo `Rating` ha l'obiettivo di fornire un'infrastruttura **agnostica e riusabile** per la gestione di criteri di valutazione e punteggi, indipendente dal dominio applicativo specifico.

## Obiettivi di business

- Definire un modello di **rating generico** applicabile a qualunque entità (utente, servizio, struttura, progetto, ecc.).
- Supportare scenari in cui **più moduli** consumano il sistema di rating senza duplicare logica o tabelle.
- Permettere la configurazione di **criteri di valutazione** flessibili (peso, scala, vincoli) mantenendo la semplicità d’uso.
- Abilitare reportistica e analisi sui punteggi senza introdurre logica di domain-specific nel modulo Rating.

## Obiettivi tecnici

- Esposizione di un `HasRatingsTrait` riusabile, con relazioni

### `roadmap.md` — Product Roadmap - Rating Module

# Product Roadmap - Rating Module

## 🎯 Vision & Strategy
Develop the Rating Module as a high-performance, specialized component of the Laraxot ecosystem.

## 🗓️ Timeline
### Q1 2026: Foundation
- Standardize Rating Module Documentation - *Status: Shipped*
- PHPStan Level 10 Audit - *Status: In Progress*

### `root-file-policy.md` — Root file policy

# Root file policy

Updated: 2026-07-08

Root hygiene for this owner follows the project rule: no root .txt files, at most four root .md files, and at most one root .code-workspace named after the module or theme.

Archived root files live in:

- docs/root-txt-files/ (0 files)
- docs/root-md-files/ (2 files)
- docs/root-code-workspace-files/ (1 files)

Current root counts after normalization: 3 markdown files, 1 workspace files.

### `root-files-hygiene.md` — Root files hygiene

# Root files hygiene

## 2026-07-08 16:51

- created `Rating.code-workspace` as the single canonical root workspace file.

### `schema.md` — Rating Module Schema


# Rating Module Schema

> **Purpose:** Defines folder rules, frontmatter standards, and workflows for AI agents.

## Module Identity

- **Name:** Rating
- **Type:** Laravel Module (Laraxot)
- **Location:** `laravel/Modules/Rating/`
- **Docs:** `laravel/Modules/Rating/docs/`

## Wiki Rules

### raw/ Rules
- ✅ Immutable — AI reads but never modifies or deletes
- ✅ Drop liberally — articles, code snippets, decisions
- ✅ Subdivide by type: `articles/`, `papers/`, `code-examples/`, `decisions/`

### wiki/ Rules

### `schemaless-attributes.md` — Spatie Laravel Schemaless Attributes - Usage in Rating Module

# Spatie Laravel Schemaless Attributes - Usage in Rating Module

This document outlines the correct usage patterns for `spatie/laravel-schemaless-attributes` within the `Rating` module. For a comprehensive guide on schemaless attributes across the PTVX project, please refer to the [main project documentation](../../../docs/claude/schemaless-attributes.md).

## 🎯 Overview

The `Rating` module heavily utilizes schemaless attributes to store dynamic configurations for ratings, such as `anno` (year), and other specific settings that can vary.

## 🚨 CRITICAL ARCHITECTURE RULE

> [!CAUTION]
> **NEVER** use `wherePivot('anno', ...)` to filter ratings by year.
> 
> The `anno` attribute is a schemaless property of the `Rating` model itself (stored in `extra_attributes`), **NOT** a column in the `ra

### `strategy.md` — Product Strategy: Rating Module

# Product Strategy: Rating Module

## 🌍 Market Context
Specialized requirement for Rating within the Public Administration sector.

## 💎 Unique Value Proposition
Agnostic, modular, and type-safe implementation of Rating logic.

### `user-interface.md` — User Interface - Modulo Rating

## User Interface - Modulo Rating

- Le risorse Filament espongono le traduzioni da `rating::` secondo la struttura espansa.
- 19/11/2025: aggiornata l'icona di navigazione di `rating_morph` eliminando il placeholder `.navigation` e usando `heroicon-o-star`.


### `user-research-2.md` — Rating Module - User Research

# Rating Module - User Research

**Module:** Rating  
**Version:** 1.0.0  
**Last Updated:** March 12, 2026  
**Owner:** Product Team

---

## Research Goals

1. Understand rating behavior
2. Identify trust factors
3. Validate review UX
4. Determine incentive effectiveness

---

## Research Questions


### `user-research.md` — User Research: Rating Module

# User Research: Rating Module

## 🔬 Research Goals
Identify user needs for Rating functionality.
