---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 45 file oltre target 100.

### `architecture.md` — Cms: architettura


# Cms: architettura

Il Cms serve le pagine pubbliche **senza controller e senza `web.php`**: le rotte sono file Folio del tema attivo, il
contenuto sono file JSON del tenant, il modulo mette il resolver, il middleware, i componenti Blade e il pannello
Filament per modificarli. Verificato sul codice del modulo (`app/`, `config/`, `routes/`, `resources/views`).

## Flusso di una richiesta pubblica

1. `Http\Middleware\RedirectUnlocalizedPath` (middleware **globale**, aggiunto da `FolioVoltServiceProvider`): un URL
   senza lingua (`/events`) va a `/it/events` solo se la pagina esiste in una cartella Folio montata; altrimenti resta
   404. La decisione e' in `Actions\RedirectUnlocalizedPathAction` (lingua da `Accept-Language`, poi default).
2. `FolioVoltServiceProvider::registerFolioPaths()

### `bmad/livewire-inventory.md` — Inventario: Livewire HTTP → Filament — modulo Cms


# Inventario: Livewire HTTP → Filament — modulo Cms

**Solo documentazione. Nessun PHP toccato in questo audit.**

Questo file è la SSoT del modulo Cms per la campagna di conversione Livewire → Filament widget. Formato e metodo sono ripresi da [Modules/User/docs/bmad/livewire-inventory.md](../../../User/docs/bmad/livewire-inventory.md), adattati al fatto che qui, a differenza di User, non esiste alcun candidato reale.

## Metodo (codice, non assunzione)

```bash
find Modules/Cms/app/Http/Livewire -type f -name '*.php'
grep -rniE "livewire[:.]page\.show|Page\\\\Show|page-show" --include="*.php" --include="*.blade.php" .
grep -rn "@livewire" Modules/Cms --include="*.blade.php"
grep -rln "<livewire:" Modules/Cms --include="*.blade.php"
find Modules/Cms/app/Filament/Widgets -type f
find Modul

### `bmad/stories/cms-app-merge-conflict-lane.story.md` — Story: lane-cms — conflitti `app/**` + `config/config.php`


# Story: lane-cms — conflitti `app/**` + `config/config.php`

## Perché

Marker di merge in Cms rompono bootstrap PHPStan e la pipeline Folio+Volt+head/Schema.org.

## Decisioni

- Base: `laraxot/dev` quando HEAD era vuoto/docs-only.
- `FolioVoltServiceProvider`: DEV + `RedirectUnlocalizedPath` (FR-15); **no** `empty.php`.
- Head / `BuildHeadSchemaAction` / `ResolvePageMetaAction`: pipeline Schema.org DEV (`business`, fallback `name`/`content`).
- `BuildPageSchemaAction` Event: riferimento `@id` (HEAD) — evita Event incompleto per Google.
- `config.php`: allowlist `auth`, `guest`, `throttle`.

## Esito

18 file in scope risolti e staged; `php -l` ok; marker residui in `app/` = 0.

## Claims

### `bmad/stories/multiple-records-cms.story.md` — CMS MultipleRecordsFoundException Fix


# CMS MultipleRecordsFoundException Fix

Root cause: `HasBlocks::getBlocksBySlug()` used `sole()` without catching
`MultipleRecordsFoundException`; 2 DB records matched slug.

Fix: try/catch around `sole()`; throws `RuntimeException` with ids/slugs
listed; `ModelNotFoundException` returns `[]`.

Source: `Modules/Cms/app/Models/Traits/HasBlocks.php:124`

Second Brain: document in docs/bmad/stories/ + log to wiki.

### `bmad/stories/story-cms-folio-locale-auth-redirect.dev.md` — Development record


# Development record

## Cause

The page metadata middleware authenticates Folio requests after `SetFolioLocale`
has resolved `en`, but Laravel's default guest redirect callback used the named
`login` route. That route generated the default `/it/auth/login` URL.

## Change

`bootstrap/app.php` overrides Laravel's `redirectGuestsTo` callback to build
`/auth/login` through `LaravelLocalization::getLocalizedURL()` using the current
resolved locale. The path fallback keeps that locale if route localization
cannot produce a URL. JSON requests continue through Laravel's 401 path.

## Verification plan / evidence

- Feature regression checks IT and EN route prefixes, app locale, facade locale,
  and redirect destination.

### `bmad/stories/story-cms-folio-locale-auth-redirect.md` — Story


# Story

Come visitatore, quando apro una pagina Folio protetta in una lingua specifica,
voglio essere mandato alla pagina di accesso nella stessa lingua, così non perdo
il contesto prima di autenticarmi.

## Acceptance criteria

1. Guest su `/it/tickets/create` riceve redirect a `/it/auth/login`.
2. Guest su `/en/tickets/create` riceve redirect a `/en/auth/login`.
3. La locale app e quella di LaravelLocalization corrispondono al prefisso della
   richiesta quando viene generato il redirect.
4. Il comportamento JSON resta non redirect (risposta 401).
5. Nessuna credenziale o configurazione `.env.testing` viene alterata per i test.

## Implementazione

`bootstrap/app.php` configura `redirectGuestsTo` con
`LaravelLocalization::getLocalizedURL()` e la locale già risolta da

### `components.md` — Componenti Blade del Cms


# Componenti Blade del Cms

Componenti PHP in `app/View/Components`, viste in `resources/views/components`. Il tema fornisce solo shell e viste dei
blocchi (namespace `pub_theme::`); la logica di dominio resta nei moduli.

| Componente | Ruolo |
|---|---|
| `<x-page side slug :data>` | rende i blocchi di una pagina; risolve il contenitore CMS, unisce il contesto di rotta nel data bag, ricorda titolo/descrizione per l'head |
| `<x-page-content>` | contenuti collegati (`PageContent`) |
| `<x-section slug tpl>` | sezione condivisa (header, footer, sidebar) da `database/content/sections`; view `pub_theme::components.sections.<slug>.<tpl>`, `tpl` di default `v1` |
| `<x-head>` / `<x-foot>` | coda e testa di ogni pagina pubblica (asset Vite, Filament, stack) |
| `<x-metatags>` | `<title>`, desc

### `content-json-pages.md` — Contenuti JSON del Cms


# Contenuti JSON del Cms

Le pagine pubbliche non stanno nel database: ogni pagina e' un file JSON del tenant, letto come riga Eloquent dal
trait `SushiToJsons` (modulo Tenant). Il JSON del tenant e' l'input editoriale di `<x-page>`: Folio possiede il
percorso, il Cms legge i dati, il tema veste i blocchi (flusso in [architecture.md](architecture.md)).

## Dove stanno i file

```
config/local/<tenant>/database/content/
├── pages/            slug "home" -> home.json, "events.my" -> events/my.json
├── sections/         header, footer e altre sezioni condivise
└── page_contents/    contenuti collegati (un file per id)
```

`<tenant>` deriva dall'`APP_URL`. `SushiToJsons::collectRowsFromJsonFiles()` legge ricorsivamente
`database/content/<tabella>/**.json`: per un file `a/b/x.json` prefissa `

### `contracts/resolve-page-action.md` — ResolvePageAction


# ResolvePageAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/ResolvePageAction.php`. Perche': [ADR](../adr/container0-model-allowlist.md).
Chiamante: pagina Folio del tema `[container0]/[slug0]`.

## Input

- `$container0`, `$slug0`: i due segmenti dell'URL dopo la lingua (dati dell'utente, non fidati).

## Output

- `ResolvePageData`: `renderMode` `model` (con `item` e `pageSlug` = `<container0>.view`) oppure `cms` (`item` null, `pageSlug`
  = `<container0>.<slug0>` se esiste quella pagina, altrimenti `<container0>.view` se esiste, altrimenti `<container0>.<slug0>`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|

### `contracts/save-footer-config-action.md` — SaveFooterConfigAction


# SaveFooterConfigAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/SaveFooterConfigAction.php`. Chiamante: pagina Filament
`app/Filament/Clusters/Appearance/Pages/Footer.php` (salvataggio del form).

## Input

- `FooterData`: dati del form footer (colori, classi, sfondo, ...).

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| CMS-FOOTER-SAVE-INV-1 | Scrive solo la chiave `footer` del file di config `appearance` del tenant, con `FooterData::toArray()`, delegando a `Modules\Tenant\Actions\Config\SaveTenantConfigAction`. | — |

### `contracts/save-headernav-config-action.md` — SaveHeadernavConfigAction


# SaveHeadernavConfigAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/SaveHeadernavConfigAction.php`. Chiamante: pagina Filament
`app/Filament/Clusters/Appearance/Pages/Headernav.php` (salvataggio del form).

## Input

- `HeadernavData`: dati del form headernav (colori, classi, sfondo, ...).

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| CMS-HEADERNAV-SAVE-INV-1 | Scrive solo la chiave `headernav` del file di config `appearance` del tenant, con `HeadernavData::toArray()`, delegando a `Modules\Tenant\Actions\Config\SaveTenantConfigAction`. | `CMS-HEADERNAV-SAVE-INV-1` |

### `contracts/validate-page-middleware-action.md` — ValidatePageMiddlewareAction


# ValidatePageMiddlewareAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/ValidatePageMiddlewareAction.php`. Perche': [ADR](../adr/page-middleware-allowlist.md).
Chiamante: `app/Http/Middleware/PageSlugMiddleware.php`. Action pura, con contratto perche' e' un confine di sicurezza.

## Input

- `$declared`: lista dei middleware letti dal campo `middleware` del JSON della pagina (es. `['auth', 'throttle:10,1']`).
- Implicito: `cms.config.page_middleware_allowlist`.

## Output

- La stessa lista, invariata, se ogni voce e' ammessa.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|

### `filament-admin.md` — Pannello Filament del Cms


# Pannello Filament del Cms

Backoffice dei contenuti: Filament **^5.0** (`laravel/composer.json`), Livewire v4, Tailwind v4. Il front office non usa
Filament per le pagine (sono Folio + JSON); Filament serve a modificare pagine, sezioni, menu e allegati e a ospitare
widget (es. form di accesso) dentro i blocchi.

## Provider, risorse, pagine

| Elemento | Classe (verificata) |
|---|---|
| Pannelli | `Providers\Filament\AdminPanelProvider`, `Providers\Filament\FrontPanelProvider` |
| Risorse multilingua | `PageResource`, `SectionResource`, `PageContentResource`, `AttachmentResource` (estendono `Modules\Lang\Filament\Resources\LangBaseResource`) |
| Risorsa non tradotta | `MenuResource` (estende `XotBaseResource`) |
| Struttura risorsa | `PageResource/{Pages,Schemas,Tables}`: `PageForm`, `

### `stories/01.cms-phpstan-fix.story.md` — BMAD Story - Cms PHPStan Fix


# BMAD Story - Cms PHPStan Fix
Date: Sun Sep  6 04:36:00 PM CEST 2026
Status: TODO - da processare con swarm

### `stories/12.1.cms-page-show-not-widget.story.md` — 12.1: Page/Show non è un Filament widget


# 12.1: Page/Show non è un Filament widget

**Story ID:** 12.1
**Epic:** 12 — Livewire → Filament widget, modulo Cms
**Slug:** cms-page-show-not-widget
**Status:** approved (story di verdetto, non di implementazione — nessun codice da scrivere)

> Solo documentazione. **Nessun PHP toccato in questa story.**

## GitHub (tracciamento)

| Risorsa | Ruolo |
|---------|-------|
| [#56](https://github.com/laraxot/module_cms_fila5/issues/56) | issue |
| [#57](https://github.com/laraxot/module_cms_fila5/discussions/57) | discussion |

```bash
gh -R laraxot/module_cms_fila5 issue create --title "12.1 Page/Show non convertire a widget" --body "Canon: laravel/Modules/Cms/docs/bmad/livewire-inventory.md"
```

### `stories/18.2.archive-convention-decision.story.md` — Archive Convention Decision (Story 18-2)


# Archive Convention Decision (Story 18-2)

## Context

Epic 18 ("Sincronizzazione Drift + Dedup Docs") requires consolidating and
deduplicating documentation spread across 6+ modules (Ui, Job, AI, Cms, Xot,
Lang, etc.). A critical blocker: **what is the canonical convention for archived
docs?**

Currently, two conventions exist in parallel:

1. **`docs/_archive/`** — underscore-prefixed, signals "meta/internal" by convention
   (used in other contexts: `_bmad/`, `_components.json`, etc.).
2. **`docs/archive/`** — plain name, possibly `.gitignore`d or not depending on
   intent.

**This story blocks story 18-3** ("Implement Dedup + Archive Strategy"), which
needs an agreed convention before proceeding.


### `stories/19.1.cms-sync-marker-repair.story.md` — 19.1.Cms: marker del sync `laraxot/dev` in head/foot Blade e nei test


# 19.1.Cms: marker del sync `laraxot/dev` in head/foot Blade e nei test

**Fase BMAD:** Dev/Review (risoluzione e verifica; nessun codice nuovo)
**Stato:** done

## Obiettivo

`phpstan analyse Modules` non parte finche' un file ha `<<<<<<<`/`>>>>>>>`. Il sync
`bashscripts/git/subtrees/merge_remote_repo_2.sh` (merge di `laraxot/dev`, poi `commit -am .`) li aveva
committati, fino a quattro livelli annidati. In `Cms` erano sette file: due Blade del front office e cinque
PHP di test. Le Blade sono `<head>` e coda del `<body>` di ogni pagina pubblica del tema Meetup
(`<x-cms::head>` in `Themes/Meetup/.../layouts/main.blade.php`): una merge sbagliata li' rompe tutto il sito.

## Risoluzione per file

| File | Scopo | Esito | Righe scartate |
|---|---|---|---|
| `resources/views/components/head.

### `stories/6.1.resolve-git-conflicts-and-phpstan.story.md` — Story 6.1: Resolve Git Merge Conflicts + PHPStan Fixes — Cms Module


# Story 6.1: Resolve Git Merge Conflicts + PHPStan Fixes — Cms Module

**Status**: docs-md-clean (2026-11-23); PHP/test ancora da chiudere se marker residui nel codice  
**Module**: Cms (independent .git)  
**PHPStan errors**: 16 (all parse-blocking merge conflicts) — baseline storica  
**Effort**: small  
**Owned by**: coordinamento multi-agente

## Coordinamento docs 2026-11-23

Sweep `Modules/Cms/docs`: **58** file ripuliti, grep `.md` a **0**. Vedi [cms-merge-conflict-resolution.story.md](./cms-merge-conflict-resolution.story.md).

## Problem

PHPStan bootstrap blocked by unresolved git merge conflicts in 3 files. All errors are `phpstan.parse` non-ignorable syntax errors from merge markers (start / mid / end).
**Status**: ready-for-dev  
**Module**: Cms (independent .git)  
**PHPStan

### `stories/7.1.phpstan-paramtype-coverage.story.md` — CMS-7.1 — Param type mancanti nel modulo Cms


# CMS-7.1 — Param type mancanti nel modulo Cms

## GitHub (tracciamento)

| Artefatto | URL |
|---|---|
| Issue (base) | https://github.com/laraxot/base_techplanner_fila5/issues/55 |
| Issue (module_cms_fila5) | https://github.com/laraxot/module_cms_fila5/issues/51 |

## User story

Come **maintainer del modulo Cms**,
voglio **ogni parametro di metodo e closure tipizzato nativamente**,
così che **il gate full-tree `phpstan analyse Modules` torni verde senza toccare i `.neon`**.

## Contesto

Story coordinatrice: `Modules/Xot/docs/stories/17.17.phpstan-modules-typecoverage-zero.story.md`.


### `stories/bmad-mod-root-cleanup.story.md` — bmad-mod-root-cleanup.story


=== BMAD Story ===
- Spostati file .md dalla root in docs/ per rispettare regola max 6
- Moduli interessati: Cms, Gdpr, Notify, UI, Xot

### `stories/cms-merge-conflict-resolution.story.md` — Story: Cms module merge conflict resolution + phpstan


# Story: Cms module merge conflict resolution + phpstan

Status: docs-markers-done (PHP/test conflicts: vedi anche `6.1.resolve-git-conflicts-and-phpstan.story.md`)
Module: Modules/Cms

## Coordinamento 2026-11-23 — docs markers

- Scope: `laravel/Modules/Cms/docs` — zero marker di merge nei `.md`.
- Puliti **58** file con conflitti annidati (`.merge_file_*`); preferenza link lowercase; FO layout invariato: sempre `@filamentStyles` / `@filamentScripts` (NO `panelAssets`) — contratto in [filament-layout-styles-scripts.md](../bmad/filament-layout-styles-scripts.md).
- Verifica: grep sui tre token di merge (start/mid/end) in `Cms/docs/**/*.md` → **0**.
- Nota operativa: [merge-conflict-marker-cleanup.md](../merge-conflict-marker-cleanup.md).

## Contesto storico

6 file PHP/test in conflitto

### `stories/cms-mixed-type-reduction.story.md` — Cms — Riduzione uso di `mixed`


# Cms — Riduzione uso di `mixed`

## Contesto

Convenzione di progetto (root `CLAUDE.md`): "cerchiamo di non usare mixed, quando lo
troviamo cerchiamo di sostituirlo con qualcosa di adeguato". Il modulo Cms aveva ~71 file
con `mixed` (native type-hint o docblock). Task best-effort ("dove possibile"), non 100%
di copertura.

## Cosa e' stato trovato

`grep -rnE '\bmixed\b' Modules/Cms --include="*.php"` -> 71 file. Di questi, solo un
sottoinsieme aveva `mixed` come **native type-hint reale** (parametro/return type di
funzione, non dentro un commento `@property`/`@method`); il resto sono docblock
`@property`/`@method static` auto-generati da ide-helper che rispecchiano le firme di
`Illuminate\Database\Eloquent\Builder` o colonne JSON traducibili — fuori scope per
narrowing (romperebbero la 

### `stories/cms-module-bmad-setup.story.md` — Cms Module BMAD Setup


# Cms Module BMAD Setup

## Overview
Initial BMAD documentation setup for the Cms module.

## Acceptance Criteria
- [ ] All BMAD docs created in `Modules/Cms/docs/`
- [ ] decision-log.md updated
- [ ] PHPStan passes on Cms module (currently 22 mixed errors)
- [ ] Pint --dirty passes

## Notes
Module has 2 Controllers that may need refactoring to Filament widgets.
22 `mixed` type errors need resolution.

### `stories/cms-root-md-file-limit-audit.story.md` — Cms root .md file limit audit


# Cms root .md file limit audit

## Fase BMAD

Dev (esecuzione diretta di una regola di igiene gia' definita, nessuna nuova feature).

## Contesto

Regola canonica: `bashscripts/ai/wiki/rules/module-theme-root-md-files-limit.md` — root di
`laravel/Modules/<Nome>/` deve avere **0** `.txt` e **max 6** `.md`. Verificato con
`find laravel/Modules/Cms -maxdepth 1 -iname '*.md' | wc -l` = **16** file (soglia superata di 10),
`.txt` = 0 (gia' conforme).

I 16 file .md in root erano quasi tutti relitti di una precedente sincronizzazione automatica
(commit `a77095a7 cms: sync docs + fix after agent AI work`, 2026-09-06) che aveva importato file
di skeleton del package pubblico `laraxot/module_cms_fila5` (`.github/workflows`, `CHANGELOG.md`,
`../license-2.md`, ecc.) insieme a report/appunti generat

### `stories/cms.deprecation-fix.story.md` — Cms.Deprecation-Fix: Spatie LaravelData v5 Migration


# Cms.Deprecation-Fix: Spatie LaravelData v5 Migration

**Story ID:** Cms.Deprecation-Fix
**Epic:** Cms — PHPStan Quality
**Slug:** laravel-data-v5-migration
**Status:** backlog

## Story

As a **CI/CD pipeline**,
I want **deprecated DataCollection methods migrated to Laravel collections**,
so that **code is ready for Spatie\LaravelData v5**.

## Acceptance Criteria

1. `filter()` on DataCollection replaced with `filter()` on Laravel collection
2. `each()` on DataCollection replaced with `each()` on Laravel collection
3. PHPStan returns 0 errors on Cms module
4. Tests still pass

### `stories/continuation.story.md` — Cms Module — Continuation Task

# Cms Module — Continuation Task

## Stato
Modulo con modifiche non ancora sincronizzate nel proprio .git.

## Task
1. Aggiungere `protected static string $model =` a tutte le table class mancanti
2. Audit `getTableColumns()` — verificare campi modello
3. Migliorare UI/UX (badge, toggleable, sortable)
4. `php -l` su tutti i file toccati
5. `git commit -m "BMAD: table audit"`

## Modelli attesi (da verificare)
- Tabella: `Modules\$m\Filament\Resources\*`
- Modello: `Modules\$m\Models\*`

### `stories/dcp-101-guardie-json-asset-manifest.story.md` — DCP-101: guardie su JSON, asset e manifest


# DCP-101: guardie su JSON, asset e manifest

## Richiesta (2026-10-13)
Gli incidenti del giorno (500 "CMS content collision", PNG a 0 byte dopo `npm run copy`, manifest e JSON non allineati) si trovavano solo guardando la pagina.
Servono test che li facciano emergere nel codice, senza database ne' HTTP. Realizza in parte DCP-09 (guardia JSON) e DCP-08 (asset senza 0 byte).

## Test
File: `laravel/Modules/Cms/tests/Unit/Content/ContentIntegrityGuardTest.php` (Pest, solo filesystem; radice = `dirname(__DIR__, 5)` = `laravel/`).

| Guardia | Incidente che protegge | Cosa lo fa fallire |
|---|---|---|
| (a) nessuno slug duplicato nella stessa cartella `content/pages` (tutti i `config/*/*` e `Modules/*/config`) | `homepage.json` + `tests.homepage.json` (poi `risultati-ricerca`) con lo stesso 

### `stories/dcp-41-url-to-json-resolver.story.md` — DCP-41: da URL a JSON


# DCP-41: da URL a JSON

## Richiesta (2026-10-13)
`/it/tickets/create` non ha e non deve avere `tests.tickets-create.json`: usa `laravel/config/local/fixcity/database/content/pages/tickets.create.json`. Capire il perche', dove si e' sbagliato e impedire che si ripeta.

## Analisi
- Slug = segmenti dell'URL. Pagina generica `[container0]/[slug0]`: `<container0>.<slug0>` (`tickets.create`). Pagina `pages/tests/[slug].blade.php`: `tests.<slug>`, `/it/tests` = `tests.index`.
- Il "tests" in `pub_theme::components.blocks.tests.ticket-crea` e' una cartella di view dei blocchi, non uno slug.
- L'errore: un doc/story (dcp-22, `fil-tickets-create-filament-wizard-parity`) ha citato un JSON `tests.tickets-create`; i risultati QMD piu' in alto descrivevano la sandbox `/it/tests/segnalazione-crea` (J

### `stories/disclaimer-verification.story.md` — Verifica Disclaimer


# Verifica Disclaimer

## Obiettivo

Verificare che tutti i disclaimer legali siano presenti e corretti in tutti i canali del ristorante digitale: pagine web, email di notifica, PDF scontrini/fatture, e stampa ticket.

## Canali da Verificare

### 1. Email (Modulo Notify)

File: `laravel/Modules/Notify/resources/views/mail/promotion.blade.php`

- Linea 54-58: `{{ $disclaimer }}` è inserito se definito, ma **nessun valore di default** è fornito
- Linea 60-64: i termini sono presenti (`notify::mail.promotion.terms`)
- **Manca**: disclaimer standard per comunicazioni commerciali (art. 7 D.Lgs. 196/2009 + art. 13 GDPR)
- **Manca**: link a privacy policy e a informativa sui cookie

### 2. Pagine Web (Modulo Cms)


### `stories/docs-index-audit.story.md` — CMS-docs — Audit indice documentazione


# CMS-docs — Audit indice documentazione

## Cosa e' stato trovato

`Modules/Cms/docs/` contiene 1166 file `.md` (570 in radice, ~596 nelle sottocartelle). La radice e' fortemente inquinata da duplicati: 136 cluster di varianti dello stesso contenuto (differenze di case, `_` vs `-`, suffissi `-1`/`_1`/`-old`/`-old2`/`-renamed`, date nel nome, e alcuni nomi corrotti da un probabile bug di script di rinomina passato, es. `filament-resourcelines.md`, `iconesign.md`, `phpstanes.md`). `docs/index.md` e `docs/index.md` erano stub placeholder auto-generati vuoti.

## Cosa e' stato fatto

Creato/aggiornato `docs/index.md` come indice di navigazione per argomento (Design Comuni, Homepage/blocchi, Filament, Folio/Volt, PHPStan/qualita, Testing, Prodotto/roadmap, UX, Governance, Architettura, ecc.),

### `stories/head-sixteen-parity-closeout.story.md` — [STORY] Chiusura parita' head Sixteen: D-7, sweep H-5 e gate go-live


# [STORY] Chiusura parita' head Sixteen: D-7, sweep H-5 e gate go-live

## Scopo

Chiudere la migrazione del `<head>` di Sixteen su `<x-cms::head>` (story madre
`head-sixteen-layout-migration.story.md`): risolvere la regressione di parita' trovata dal diff a 128 URL,
eseguire lo sweep di parita' H-5 completo e riportare verdi i cancelli `LG-03`/`LG-04` del go-live gate.

## Perche' (il senso)

La testa scritta a mano emetteva canonical e hreflang **su ogni pagina**, incluse quelle `noindex`
(`x-layouts.seo-links`). Il componente Cms le emette solo sulle pagine indicizzabili: e' SEO-coerente
(`noindex` sconsiglia la canonicalizzazione) ma e' una **divergenza non coperta da nessuna decisione approvata**
e fa fallire `LG-03`/`LG-04` (DCP-166, 12 su 48). Finche' non si decide, il gate resta r

### `stories/homepage-audit-story.md` — Homepage Audit Story

# Homepage Audit Story

## User Job + Success State
Come visitatore del sito, voglio una homepage chiara, veloce e moderna che mi mostri subito le informazioni principali, con accesso rapido alle sezioni del portale, per avere un'esperienza utente fluida e trovare rapidamente ciò che cerco.

## Screen Inventory
- **Header**: Logo, menu principale, ricerca
- **Hero section**: Titolo principale, call-to-action primaria
- **Featured content**: Ultimi articoli, segnalazioni attive, KPI in evidenza
- **Sidebar/Secondary**: Link rapidi, categorie
- **Footer**: Navigazione, contatti, link utili

## Token Constraints (from DESIGN.md)
- **Palette**: Accento `forest #1E6B50`, neutri tintati `paper #F6F4EE`, `ink #22302A`
- **Typography**: Testata `Spline Sans 700–800`, corpo `IBM Plex Sans 400/1rem-

### `stories/phpstan-cleanup-cms.dev.md` — [DEV] PHPStan cleanup modulo Cms


# [DEV] PHPStan cleanup modulo Cms

## Technical Plan

1. Per ogni file: leggere cosa deve fare, `grep` dei chiamanti, `git log -S` per capire se la variabile "mai letta" era logica persa.
2. Codice di produzione: correggere la funzionalita' (fallback email), rimuovere solo il codice davvero morto, tipizzare.
3. Test: ogni `$x = ...` mai letto diventa un'asserzione di comportamento verificabile **leggendo il codice** (i test non sono eseguibili qui).
4. Enum: nessuna costante di insieme di valori nel gruppo; l'enum esistente (`AttachmentDiskEnum`) aveva traduzioni mancanti.
5. Docs: write-back in `docs/actions/page-resolution-pipeline.md` e indice.

## Files to Modify

Produzione (`app/`): `Actions/BuildPageSchemaAction.php`, `Support/PageSchemaBuilder.php` (duplicato, stessa correzione),

### `stories/phpstan-cleanup-cms.story.md` — [STORY] PHPStan cleanup modulo Cms


# [STORY] PHPStan cleanup modulo Cms

## User Request

> sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalita', non sull'errore;
> aumenta la qualita' del codice; usa enum al posto delle costanti.

Gruppo Cms: 111 errori in 51 file (`laravel/Modules/Cms/**`). Nessun file spostato o cancellato, nessun `phpstan.neon`/baseline toccato.

## Analysis

Il modulo Cms gestisce pagine/sezioni/blocchi (`BlockData`, `HasBlocks`, `x-page`). Gli errori non erano cosmetici:
la maggior parte dei "variabile mai letta" nei test erano test **senza asserzione** (creavano l'oggetto e finivano li').

| Area | Cosa doveva fare | Cosa mancava / era sbagliato |
|------|------------------|-------------------------------|
| `BuildPageSchemaAction` / `PageSchemaBuilder` | JSON-LD `Per

### `stories/phpstan-cms-fix.md` — Problema


## Problema
PHPStan errors in Modules/Cms

## Solution
1. Analyze with phpstan
2. Fix pattern errors
3. Verify with phpmd + phpinsights + pest
4. Git sync

## Fix applicato — subagent-ai-gdpr-cms (2026-09-10)

- File: `Modules/Cms/tests/Unit/Actions/ResolvePageActionTest.php` (righe 19 e 23)
- Errore: `ignore.unmatchedIdentifier` (non-ignorable) — due commenti
  `@phpstan-ignore method.notFound` sopra `$this->skipTest(...)` non coprivano più
  nessun errore reale: `skipTest()` è un metodo reale definito in
  `Modules/Xot/tests/XotBaseTestCase.php:130`, quindi l'ignore era diventato stale.
- Fix: rimossi i due commenti `@phpstan-ignore method.notFound` ormai inutili, lasciato
  invariato il codice sottostante (le due chiamate a `skipTest(...)`).
- Verifica: `cd laravel && ./vendor/bin/phps

### `stories/phpstan-fix-2.story.md` — phpstan-fix-2.story



### `stories/phpstan-fix.story.md` — phpstan-fix.story



### `stories/phpstan-safe-preg-stringable.story.md` — PHPStan: Safe\preg_replace e stringhe


# PHPStan: Safe\preg_replace e stringhe

`Safe\preg_replace` dichiara `string|array` anche per un input stringa. I punti del modulo che subito dopo usavano il risultato come stringa
ora passano da `Str::of(...)->replaceMatches(...)->toString()`. Motivazione e elenco completo sono nella story omonima di Xot.

### `stories/placeholder-translations-cleanup.story.md` — Via le traduzioni segnaposto dai file di lingua


# Via le traduzioni segnaposto dai file di lingua

Rimosse le voci `helper_text`, `placeholder`, `description`, `tooltip`, `label`, `heading` e `hint` uguali al nome del
campo. Le aveva scritte il salvataggio automatico delle chiavi mancanti (`AutoLabelAction`, solo in locale) e
comparivano in produzione come testo sotto e dentro i campi. Eliminati anche i file `.php` senza nome.

Strumento: `php artisan lang:clean-placeholders {Modulo} [--dry-run]` (modulo Lang). Tocca solo i file di soli
dati: quelli che chiamano funzioni restano come sono.

### `stories/untranslated-detail-pages-indexing.story.md` — [STORY] Pagine di dettaglio non tradotte: lingua dichiarata, indicizzazione e hreflang


# [STORY] Pagine di dettaglio non tradotte: lingua dichiarata, indicizzazione e hreflang

**Discussione (decisioni e alternative scartate):** [#95](https://github.com/laraxot/theme_sixteen_fila5/discussions/95), complementare a [#93](https://github.com/laraxot/theme_sixteen_fila5/discussions/93) (head SEO, D-1..D-7).

## Fase BMAD

**Analysis** chiusa con misura; **decisione aperta** (PO). Nessun codice scritto. Origine: difetto `F-07` dell'audit anonimo del front office
([story madre](../../../../Themes/Sixteen/docs/stories/front-office-production-readiness-audit.story.md)). La story di chiusura dell'head
([head-sixteen-parity-closeout](head-sixteen-parity-closeout.story.md)) lo cita in una riga come «decisione di prodotto separata»: questa è quella decisione. ECC: `seo-specialist` come 

### `stories/xotbaseresourcetable-model-audit-cms-batch-marco.story.md` — Cms — XotBaseResourceTable model audit (batch cms-batch-marco)


# Cms — XotBaseResourceTable model audit (batch cms-batch-marco)

## Contesto

Batch di audit cross-modulo su tutte le classi `abstract class X extends
XotBaseResourceTable`: aggiungere `protected static string $model`, verificare
`getTableColumns()` contro lo schema reale, migliorie UX additive a basso rischio.
Questo modulo (Cms) ha 5 file nello scope.

## Task 1 — `protected static string $model`

All'apertura del batch, i 5 file risultavano gia' modificati (non committati) nel working
tree con la property `protected static string $model = X::class;` aggiunta subito dopo
l'apertura della classe, con `use` corretto in testa al file. Verificato che il valore
coincide con quello autorevole dichiarato nella Resource sorella (`protected static
?string $model = X::class;`):

| Table | Model 

### `theme-and-assets.md` — Temi e asset


# Temi e asset

## Come si sceglie il tema pubblico

Il tema non e' scritto nel codice: dipende dal tenant.

1. `APP_URL` (`.env`) -> il modulo Tenant ricava il nome del tenant -> cartella `laravel/config/local/<tenant>/`.
2. `config/local/<tenant>/xra.php`, chiave `pub_theme` (es. `'Meetup'`) -> `laravel/Themes/<Tema>`.
3. Namespace Blade `pub_theme::` (viste del tema); `XotData::getPubThemeViewPath('pages')` e' la cartella Folio
   che `FolioVoltServiceProvider` monta per ogni lingua ([architecture.md](architecture.md)).

`SettingPage` (pannello) elenca solo i temi esistenti (`ListInstalledThemesAction`): un `pub_theme` inventato fa fallire il boot.

## Cosa deve avere un tema

```
Themes/<Tema>/
├── resources/views/
│   ├── pages/                      rotte Folio (shell sottili che inv

### `wiki/concepts/claude-audit-static.md` — claude-audit static (Cms)


# claude-audit static (Cms)

## Comando

```bash
bash bashscripts/tools/run-claude-audit-module-static.sh Cms
```

## Fix applicati (80/0)

- Lang `section.php` / `txt.php` → cartelle `lang/{locale}/{name}/*.php` (+ split `fields/` se >500 LOC)
- `ResolvePageAction` — estratti `findViaEloquentQueries` / `findViaRawTable` (nesting)
- `FolioVoltServiceProvider` — `resolveBaseMiddleware()`
- `livewire/menu/builder.blade.php` → partials

## Report

`Modules/Cms/.claude-audit/audit-report.html`

### `wiki/concepts/cms-page-middleware-json-ssot.md` — Middleware per pagina CMS (JSON)


# Middleware per pagina CMS (JSON)

## Scopo

Definire **access control per pagina** nel JSON CMS (`config/local/.../content/pages/*.json`), eseguito a runtime da `PageSlugMiddleware` sul Folio della pagina.

## Contratto JSON

```json
{
  "slug": "tickets.create",
  "middleware": ["auth"]
}
```

Alias supportati come su Laravel (`auth`, `guest`, parametri `throttle:60,1`), ma solo i nomi presenti in `cms.config.page_middleware_allowlist` (default `auth`, `guest`, `throttle`): `verified` o una classe FQCN vanno prima aggiunti all'allowlist, ogni altro nome lancia `InvalidArgumentException` (`ValidatePageMiddlewareAction`).
Alias supportati come su Laravel (`auth`, `guest`, `verified`, classi FQCN, parametri `throttle:60,1`).
Alias supportati come su Laravel (`auth`, `verified`, classi FQC

### `wiki/topics/user-research.md` — Topic user-research


# Topic user-research

Sintesi automatica di 3 documenti (chiave `user-research`).

## Cms Module - User Research

_Fonte: `user-research-2.md`_

# Cms Module - User Research

**Module:** Cms  
**Version:** 1.0.0  
**Owner:** Product Team

---

title: "USER RESEARCH"
type: note
tags: [documentation]
