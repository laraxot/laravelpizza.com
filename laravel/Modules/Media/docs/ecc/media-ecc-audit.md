---
title: "ECC audit operativo — Media"
type: ecc-audit
status: review
updated: 2026-11-16
module: Media
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
qmd: "ECC audit Media verification security testing laravel checklist security-review clean-code verification-loop inventario misurato finding guard prunable cast id"
=======
=======
=======
<<<<<<< HEAD
qmd: "ECC audit Media verification security testing laravel checklist security-review clean-code verification-loop inventario misurato finding guard prunable cast id"
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_GKGpqq
qmd: "ECC audit Media checklist security-review clean-code verification-loop inventario misurato finding guard prunable cast id"
=======
qmd: "ECC audit Media verification security testing laravel checklist security-review clean-code verification-loop inventario misurato finding guard prunable cast id"
>>>>>>> .merge_file_evDJwh
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
qmd: "ECC audit Media verification security testing laravel checklist security-review clean-code verification-loop inventario misurato finding guard prunable cast id"
>>>>>>> laraxot/dev
related:
  - ./00-index.md
  - ../bmad/audits/media-audit.md
  - ../bmad/audit.md
---

# ECC audit operativo — Media

## Contratto PTVX

<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_GKGpqq
ECC non sostituisce AGENTS.md/BMAD. Ogni finding: story BMAD, lock, fix causa,
PHPStan + Pest, aggiornamento docs/QMD.

## Checklist

- [ ] `clean-code`: DRY/KISS, Actions su Services, niente wrapper inutili
- [ ] `security-review`: policy, mass assignment, export, log, privacy, tenant
- [ ] `laravel-verification`: route, config, migration additive, container
- [ ] `verification-loop`: PHPStan level max + Pest mirato
- [ ] `tdd-workflow`: regressione sui finding P0
- [ ] `documentation-sync`: story + indici + qmd
- [ ] `context-engineering`: QMD/graphify prima; registrare il perché dopo

## Input misurato (2026-11-16)
=======
>>>>>>> .merge_file_evDJwh
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
ECC non sostituisce `AGENTS.md`/BMAD. Ogni finding: story BMAD, lock, fix alla causa, PHPStan + Pest, aggiornamento docs/QMD. Dettaglio: [audit profondo](../bmad/audits/media-audit.md).

## Checklist (stato misurato 2026-11-16)

| Skill ECC | Stato | Evidenza |
|---|---|---|
| `clean-code` | **aperto** | 3 Action e 3 classi HTTP senza caller; junk (`.backup-…`, `.to_xot`); `print_r` in `ConvertVideoCommand` |
| `security-review` | **aperto — 0 P0, 3 P1** | pagine `AwsTest`/`S3Test` senza guard; `StreamVideoAction` con controllo aggirabile (latente); cancellazione fisica |
| `laravel-verification` | **aperto** | `TemporaryUpload::prunable()` commentato → `model:prune` fallisce; cast `id` ≠ schema |
| `verification-loop` | PHPStan: 0 errori — Pest: parziale (49 pass / 1 fail su `tests/Unit/Models`) | |
| `tdd-workflow` | **aperto** | 5 file «coverage» (719 r.), 2 `->todo()` vuoti |
| `context-engineering` | in uso | QMD/graphify prima; registrare il perché dopo |
| `documentation-sync` | **fatto in questo giro** | architecture riscritta, decision-log/epics gap-fill, purpose con stato; 31/512 `.md` con nome non conforme |

## Inventario misurato

| Voce | N |
|---|---:|
| app PHP | 127 |
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_GKGpqq
| test | 47 |
| resources | 3 |
| actions | 51 |
| services | 0 |
| policies (files approx) | 8 |

## Gate osservati

- PHPStan `Modules` (2026-11-16): 0 errori
- Pest: pending (ambiente testing)

## Anti-pattern vietati

- baseline/`@phpstan-ignore` senza motivazione
- test svuotati per silenziare errori
- migrate:fresh / RefreshDatabase / --force
- docs con date nel nome file
- comportamento o screenshot inventati
=======
>>>>>>> .merge_file_evDJwh
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
| test PHP / `*Test.php` | 47 / 41 |
| Models / Policy / Resource | 4 / 4 / 3 |
| Pagine Resource / pagine cluster `Test` / Widget | 15 / 2 / 1 |
| Actions / Services | 51 / 0 |
| Migration | 5 |
| Lang IT | 24 |
| `return true` in Policy | 2 (`before()`) |
| `@phpstan-ignore` | 2 |
| Marker conflitto | 0 |

## Gate osservati

- PHPStan `Modules/Media` (`--no-progress`): **0 errori**.
- Pest `Modules/Media/tests/Unit/Models` su scratch DB: **49 pass, 1 fail** (cast `id`, [P1-3](../bmad/audits/media-audit.md#p1-3--mediaid-è-cast-a-string-ma-la-chiave-è-bigint)).
- `php artisan model:prune --pretend --model='Modules\Media\Models\TemporaryUpload'`: `LogicException` (sola lettura).

## Anti-pattern vietati (stato)

`migrate:fresh`: 0; `RefreshDatabase`: 0; `@phpstan-ignore`: 2; `dd()`: 0; `->label()`/titoli letterali: ≥ 12 in `AwsTest`, 1 in `ConvertAction`; `$guarded = []`: 1 (`TemporaryUpload.php:99`).
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< .merge_file_GKGpqq
=======
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
<<<<<<< .merge_file_GKGpqq
=======
>>>>>>> laraxot/dev
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev

Regole sempre valide: niente baseline/`@phpstan-ignore` senza motivazione, niente test svuotati per silenziare errori,
mai `migrate:fresh` / `RefreshDatabase` / `--force`, niente date nel nome dei file docs, niente comportamento o
screenshot inventati.
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_evDJwh
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_evDJwh
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_evDJwh
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev

## Riferimenti

- [00-index](./00-index.md)
- [BMAD audit](../bmad/audit.md)
