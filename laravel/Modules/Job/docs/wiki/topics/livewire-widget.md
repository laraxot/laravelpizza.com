---
title: "Topic livewire-widget"
type: digest
status: active
qmd: "digest ceiling 100 livewire-widget"
---

# Topic livewire-widget

Sintesi automatica di 10 documenti (chiave `livewire-widget`).

## Architecture Job

_Fonte: `bmad/livewire-widget-architecture.md`_

# Architecture Job

```
QueueListenWidget / ClockWidget → restano (XotBaseWidget, discoverWidgets)
JobStatus (Filament Page)      → gemello nativo di Job\Status (Cluster B)
Http/Livewire/*                → ritiro: Broad (dd), Schedule\*, Job\Status via 12.x
Futuro monitor Artisan         → Filament Page + policy, non discoverWidgets
```

Zero candidati Cluster A: vedi [livewire-inventory.md](./livewire-inventory.md).

## Brainstorming

_Fonte: `bmad/livewire-widget-brainstorming.md`_

# Brainstorming

Scartato: dashboard card `queue:clear`. Scelto: ritiro orfani; tool pericolosi = Page + policy. Audit 2026-09-21: `JobStatus` Page già replica gli acts di `Job\Status` → Cluster B (ritiro, non conversione). Zero Cluster A.

## Job — canone

_Fonte: `bmad/livewire-widget-conversion.md`_

# Job — canone

SSoT: [livewire-inventory.md](./livewire-inventory.md). Verdetto audit 2026-09-21: **zero candidati Cluster A** — nessun componente Job è montato in uno slot widget del chrome Filament. `Job\Status` è Cluster B (gemello parziale: Filament Page `JobStatus`, non widget). `Broad` è di nuovo presente su disco con `dd('fine')` (regressione story 12.1). Non montare Artisan `queue:clear` in un widget scoperto.

## Decision log

_Fonte: `bmad/livewire-widget-decision-log.md`_

# Decision log

## [2026-09-21] Ritiro Broad per `dd`

Docs only.

## [2026-09-21] Audit inventario: zero Cluster A, Broad regredito

Verifica repo-wide ([livewire-inventory.md](./livewire-inventory.md)): `Job\Status` montato solo nel body di `JobMonitor` (gemello pagina `JobStatus` → Cluster B); `Schedule\Status`/`Schedule\Crud` solo in viste `admin/**` irraggiungibili (Cluster C); `Broad` presente su disco nonostante story 12.1 `done`. Nessuna conversione in widget: Artisan-runner + scrittura `.env` non sono materiale da `XotBaseWidget`.

## Epic 12

_Fonte: `bmad/livewire-widget-epics.md`_

# Epic 12

Nessuna story di conversione: zero candidati Cluster A (vedi [livewire-inventory.md](./livewire-inventory.md)).

| ID | Intent | Status |
|----|--------|--------|
| 12.1 | Ritiro Broad + gate orfani Status/Crud | **done (ri-verificato 2026-09-22):** `Broad.php` assente, `_components.json` senza `broad`, `dd(` zero in Livewire |
| 12.2 (proposta, docs only) | Ritiro Cluster B: `Job\Status` + `JobMonitor`/`job-monitor.blade.php` → pagina nativa `JobStatus` (decidere gap `saveEnv`/`dummyAction`) | candidate |
| 12.3 | Marker conflitto README + igiene root | **done** — [story](stories/0001-root-hygiene-conflict-markers.story.md) |

## PRD Job

_Fonte: `bmad/livewire-widget-prd.md`_

# PRD Job

### FR-J001 [MUST] `Broad.php` assente (contiene `dd`). **Verificato 2026-09-22:** file assente, alias `broad` assente da `_components.json`, `dd(` zero in `Http/Livewire`.
### FR-J002 [MUST] `Schedule\Status`/`Schedule\Crud` assenti: grep chiamanti vivi = zero (solo viste `admin/**` irraggiungibili). `Job\Status` ha un chiamante vivo (`job-monitor.blade.php:7`): ritiro subordinato al gemello `JobStatus` (Cluster B, FR-J005).
### FR-J003 [SHOULD] Se il prodotto vuole di nuovo queue monitor: pagina Filament, non widget KPI, auth super-admin.
### FR-J004 [MUST] Non copiare `putenv` / `queue:clear` in un widget scoperto in dashboard.
### FR-J005 [SHOULD] Cluster B: ritirare `Job\Status`+`JobMonitor` a favore della pagina nativa `JobStatus`, dopo decisione su `saveEnv`/`dummyAction`.

## Brief

_Fonte: `bmad/livewire-widget-product-brief.md`_

# Brief

Togliere `Broad` (di nuovo presente con `dd`) e gli HTTP orfani `Schedule\Status`/`Schedule\Crud`. `Job\Status` va ritirato verso la pagina Filament `JobStatus` già esistente (Cluster B), non convertito in widget. Queue live resta `QueueListenWidget`. Metrica: `Http/Livewire` vuoto; zero `dd(` nei componenti UI; zero tag `<livewire:*>` residui in viste `admin/**` morte.

## Context Job

_Fonte: `bmad/livewire-widget-project-context.md`_

# Context Job

Job è code asincrono. L’UI admin è Filament (code, schedule). HTTP che lancia Artisan è un admin tool, non un fragment menu. `dd()` in Broad è un incidente in attesa — ed è di nuovo su disco (regressione 12.1, vedi [livewire-inventory.md](./livewire-inventory.md)). Registro alias Livewire piatto e globale (`XotBaseServiceProvider::registerLivewireComponents`, prefix `''`): un file in `Http/Livewire` è sempre esposto anche senza mount.

## Tech spec Job

_Fonte: `bmad/livewire-widget-tech-spec.md`_

# Tech spec Job

Stato verificato (audit [livewire-inventory.md](./livewire-inventory.md)):

1. `Broad.php` + `livewire/broad.blade.php` + entry `broad` in `_components.json`: **presenti di nuovo** — ritiro 12.1 da rieseguire e committare.
2. Alias reali (registro piatto, prefix `''`): `broad`, `job.status`, `schedule.crud`, `schedule.status`. Grep temi/base su questi nomi, non su `job.broad`.
3. Chiamanti vivi: solo `job.status` in `filament/pages/job-monitor.blade.php:7` → Cluster B, ritiro condizionato a `JobStatus` Page. `Schedule\*`: solo viste `admin/**` irraggiungibili → rimozione viste + classi.
4. Aggiornare `tests/Unit/JobExecuteCoverage50Test.php` (righe 35, 303, 400 referenziano le classi).
5. PHPStan sui file toccati. Non toccare neon.

## UX

_Fonte: `bmad/livewire-widget-ux.md`_

# UX

Unico impatto visivo possibile: `job.status` è il body della pagina `JobMonitor` (`job::admin`). Il ritiro Cluster B sostituisce quel contenuto con la pagina nativa `JobStatus` (stessa tabella acts `queue:*`, stesso chrome Filament) → nessuna regressione percepita. `Schedule\*` e `Broad` non sono montati in nessuna UI raggiungibile: rimozione invisibile. Queue UI resta `QueueListenWidget`/`ClockWidget`.
