---
title: "ECC audit operativo — Job"
type: ecc-audit
status: review
updated: 2026-11-16
module: Job
qmd: "ECC audit Job checklist security-review clean-code verification-loop inventario misurato finding scheduler policy"
related:
  - ./00-index.md
  - ../bmad/audits/job-audit.md
  - ../bmad/audit.md
---

# ECC audit operativo — Job

## Contratto PTVX

<<<<<<< .merge_file_9hXCLd
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
>>>>>>> .merge_file_I3CCFd
ECC non sostituisce `AGENTS.md`/BMAD. Ogni finding: story BMAD, lock, fix alla causa,
PHPStan + Pest, aggiornamento docs/QMD. Dettaglio: [audit profondo](../bmad/audits/job-audit.md).

## Checklist (stato misurato 2026-11-16)

| Skill ECC | Stato | Evidenza |
|---|---|---|
| `clean-code` | **aperto** | 1 Service morto (`ScheduleService`), 2 coppie di Action duplicate, junk `.aaa`/`.pid`/`.backup`, `Config/` vs `config/` |
| `security-review` | **P0-1 chiuso; resta P0-2 + P1** | E1: deny-default + JobResource senza create; Livewire Status allowlist; scheduler D-2 e widget guard aperti |
| `laravel-verification` | **aperto** | scheduler non cablato (`JobServiceProvider.php:38,48-66`); `ExecuteTaskAction.php:18` stub |
| `verification-loop` | PHPStan: 0 errori — Pest: parziale (17 pass su `JobStatusAuthorizationTest`) | |
| `tdd-workflow` | **aperto** | 0 `Livewire::test`; `migrate:fresh` non mockato in `ScheduleStatusWidgetTest.php:14` |
| `documentation-sync` | **fatto in questo giro** | gap-fill purpose/architecture/decision-log/epics/brainstorming; 101/625 `.md` senza frontmatter |
| `context-engineering` | ok | story 12.1 riaperta dal decision-log (D-4) |

## Inventario misurato

| Voce | N |
|---|---:|
| app PHP | 176 |
<<<<<<< .merge_file_9hXCLd
| test | 84 |
| resources | 9 |
| actions | 16 |
| services | 1 |
| policies (files approx) | 32 |

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
>>>>>>> .merge_file_I3CCFd
| test PHP / `*Test.php` / casi Pest | 55 / 49 / 369 |
| Models / Policy / Resource | 17 / 16 / 9 |
| Pagine standalone / pagine Resource / Widget | 4 / 26 / 8 |
| Actions / Services | 16 / 1 |
| Migration | 14 |
| Lang IT | 57 |
| `return true` in Policy | 5 (2 `before()`, 3 `create()`) |
| Marker conflitto | 0 |

## Gate osservati

- PHPStan `Modules/Job` (`--no-progress`): **0 errori**.
- Pest `Modules/Job/tests` su scratch DB: **parziale** — `JobStatusAuthorizationTest` 17 pass; suite completa non eseguita per carico macchina.

## Anti-pattern vietati

- baseline/`@phpstan-ignore` senza motivazione
- test svuotati per silenziare errori
- `migrate:fresh` / `RefreshDatabase` / `--force`
- docs con date nel nome file
- comportamento o screenshot inventati

### Stato misurato

`migrate:fresh` in produzione/CI: 0; in test: 6 occorrenze, 5 negative con mock, **1 non mockata** (P1-3). `RefreshDatabase`: 0. Baseline/`@phpstan-ignore`: 0. `dd()`: 1 (legacy).

## Riferimenti

- [00-index](./00-index.md)
- [BMAD audit](../bmad/audit.md)
