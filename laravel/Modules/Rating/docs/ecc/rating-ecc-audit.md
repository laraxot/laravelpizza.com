---
title: "ECC audit operativo — Rating"
type: ecc-audit
status: review
updated: 2026-11-16
module: Rating
qmd: "ECC audit Rating security-review verification-loop clean-code rating_morph integrità migration trait morti"
---

# ECC audit operativo — Rating

Contratto: ECC non sostituisce AGENTS.md/BMAD. Ogni finding → story BMAD, lock, fix della causa, PHPStan + Pest, aggiornamento docs/QMD. Dettaglio: [rating-audit.md](../bmad/audits/rating-audit.md).

## Checklist ECC con esito

| Skill ECC | Esito | Evidenza |
|---|---|---|
| `clean-code` | **FAIL** (P2) | trait morti `RatingTrait`/`HasRating`; policy `Base*` duplicate; 5 file `.bak/.old/.to_*` in `app/` |
| `security-review` | parziale | nessun P0; `isOwner` con `===` nega in silenzio ([RatingMorphPolicy.php:88,95](../../app/Models/Policies/RatingMorphPolicy.php)); `ruvector.db` binario tracciato |
| `laravel-verification` | **FAIL** (P1) | `rating_morph` senza FK/unique ([migration:24-26](../../database/migrations/2026_07_27_100005_create_rating_morph_table.php)); schema in 3+3 migration |
| `verification-loop` | PHPStan OK / Pest SKIP | 0 errori level max; Pest timeout 420 s (DB test irraggiungibile) |
| `tdd-workflow` | **aperto** | nessun test su duplicati/orfani del morph |
| `documentation-sync` | fatto | audit, epics, decision-log, architecture riallineati; `qmd update` da lanciare |

## Input misurato (2026-11-16)

| Voce | N |
|---|---:|
| app PHP | 76 |
| test PHP | 42 |
| Resource | 4 |
| Actions | 3 |
| Policy | 4 |
| Migration radice | 8 |

## Gate osservati

- `phpstan analyse Modules/Rating` (level max, no baseline): **0 errori**.
- Pest: **skip documentato** — run completo in timeout (exit 124, 420 s); singolo test >150 s a 1% CPU; `10.100.200.53:3306` irraggiungibile.

## Anti-pattern vietati (verificati assenti)

`dd`/`dump` (0), `env()` in `app/` (0), marker conflitto (0), `label('…')` hardcoded (0), `RefreshDatabase`/`migrate:fresh` (0).

## Riferimenti

[00-index](./00-index.md) · [BMAD audit](../bmad/audit.md) · [story](../bmad/stories/0066-module-bmad-audit.story.md)
