---
title: "Media - brainstorming"
type: brainstorming
module: "Media"
tags: [media, brainstorming, risks, open-questions, decisions]
created: 2026-09-28
updated: 2026-10-07
qmd: "Media brainstorming decisioni aperte scartate rischi validazione"
related:
  - ./README.md
  - ./architecture.md
  - ./brainstorming/module-opportunities.md
  - ./epics/module-roadmap.md
  - ./coverage.md
---

# Media - brainstorming

> **SUMMARY**: indice dei contenuti di brainstorming per `Modules\Media`.
> Le domande ad alto valore, ipotesi, rischi e output attesi sono nei **shard**
> sottostanti (non sovrascritti). Questo file root funge da indice.

## Shard brainstorming

| Shard | Descrizione |
|---|---|
| [brainstorming/module-opportunities.md](./brainstorming/module-opportunities.md) | domande ad alto valore, ipotesi da validare, rischi |

## Decisioni prese

| Decisione | Stato | Riferimento |
|---|---|---|
| Connessione DB `media` separata, fissata in `BaseModel` | approvata | `app/Models/BaseModel.php` |
| `Media` estende `SpatieMedia` | approvata | `app/Models/Media.php` |
| `TemporaryUpload` implementa `HasMedia` | approvata | `app/Models/TemporaryUpload.php` |
| Conversioni FFmpeg orchestrate da `ResolveMediaExporterAction` | approvata | `app/Actions/Ffmpeg/ResolveMediaExporterAction.php` |
| Diagnostica AWS in `app/Actions/Diagnostic/` | approvata | `app/Actions/Diagnostic/` |

## Domande aperte

| Domanda | Fonte | Priorita' |
|---|---|---|
| API pubblica e invarianti del modulo | `architecture/module-boundary.md` sezione "Decisioni da confermare" | alta |
| Flussi con transazioni, autorizzazione e audit | `architecture/module-boundary.md` sezione "Decisioni da confermare" | alta |
| Copertura Pest rappresentativa (vedi [coverage.md](./coverage.md)) | `tests/` | media |
| Integrazioni esterne obbligatorie vs opzionali | `composer.json`, `app/Actions/` | media |

## Rischi

| Rischio | Evidenza |
|---|---|
| Duplicazione tra Form/Table | `app/Filament/Resources/MediaResource/Tables/MediaTable.php` vs `MediasTable.php` |
| Contratti impliciti Eloquent | `app/Models/Media.php` relazioni via `@property` |
| Drift docs / codice / stories | `docs/bmad/stories/` multipli |
| WIP concorrente e marker merge | `stories/git-status-fleet-merge-markers-media.story.md` |
| Directory duplicate (`app/conversions` vs `app/Conversions`) | `app/conversions/`, `app/Conversions/` |
| Directory duplicate (`tests/unit` vs `tests/Unit`) | `tests/unit/`, `tests/Unit/` (story [16-4](../stories/16-4-media-case-variant-consolidation.md)) |

## Elementi non approvati (scartati o fuori scope)

| Elemento | Motivo |
|---|---|
| Clone annidato `Activity/Activity/` | fuori scope (vedi story 5.249) |
| Refactor proposto in architettura | da marcare esplicitamente come proposta non applicata |

## Opzioni sui finding dell'audit 2026-11-16

Evidenze in [audits/media-audit.md](./audits/media-audit.md); decisioni in [decision-log.md](./decision-log.md).

| Opzione | Idea | Pro | Contro |
|---|---|---|---|
| O1 | Collection «documentale» protetta (D-3, B) | protegge solo ciò che è prova | serve classificare le collection esistenti |
| O2 | `SoftDeletes` su `Media` (D-3, A) | cancellazione reversibile ovunque | il file su disco resta |
| O3 | Cancellare il codice senza caller (D-5) | meno superficie d'attacco | se serve in futuro va riscritto con policy |
| O4 | Spostare la diagnostica AWS/S3 in un modulo ops con guard (D-4) | confini più chiari | migrazione di 2 pagine e delle relative Action |

Domande aperte per il committente: quali collection contengono allegati-prova? Lo streaming video e la conversione FFmpeg servono ancora?

## Vedi anche

- [README](./README.md)
- [Architecture](./architecture.md)
- [Epic roadmap](./epics/module-roadmap.md)
- [Module opportunities (shard)](./brainstorming/module-opportunities.md)
