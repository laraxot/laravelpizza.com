---
title: "ECC audit operativo — Lang"
type: ecc-audit
status: review
updated: 2026-11-16
module: Lang
qmd: "ECC audit Lang checklist security-review clean-code verification-loop inventario misurato finding tracker chiavi mancanti test coverage"
related:
  - ./00-index.md
  - ../bmad/audits/lang-audit.md
  - ../bmad/audit.md
---

# ECC audit operativo — Lang

## Contratto PTVX

ECC non sostituisce `AGENTS.md`/BMAD. Ogni finding: story BMAD, lock, fix alla causa, PHPStan + Pest, aggiornamento docs/QMD. Dettaglio: [audit profondo](../bmad/audits/lang-audit.md).

## Checklist (stato misurato 2026-11-16)

| Skill ECC | Stato | Evidenza |
|---|---|---|
| `clean-code` | **aperto** | `Write/ReadTranslationFileAction` morte; `config/lang.php` mai letto; `TranslatorTraitPhpstanProbe` in `app/`; 3 generazioni di migration |
| `security-review` | **nessun P0/P1** | policy su `LangBasePolicy` senza `return true` fuori da `before()`; difesa in profondità mancante su `GetTransPathAction` (P2) |
| `laravel-verification` | **aperto** | `registerTranslator()` non chiamato (`LangServiceProvider.php:43`) |
| `verification-loop` | PHPStan: 0 errori — Pest: parziale (10 pass / 13 fail su `tests/Feature`) | |
| `tdd-workflow` | **aperto** | 4 test «coverage» (2.248 r.); due alberi `tests/Unit` e `tests/unit` |
| `documentation-sync` | **fatto in questo giro** | architecture riscritta, decision-log/epics/purpose gap-fill; 111/955 `.md` con nome non conforme |

## Inventario misurato

| Voce | N |
|---|---:|
| app PHP | 72 |
| test PHP / `*Test.php` | 51 / 29 |
| Models / Policy / Resource | 7 / 4 / 2 |
| Pagine Resource / Widget | 9 / 1 |
| Actions / Services | 17 / 0 |
| Migration | 11 |
| Lang IT | 33 |
| `return true` in Policy | 2 (`before()`) |
| Marker conflitto | 0 |

## Gate osservati

- PHPStan `Modules/Lang` (`--no-progress`): **0 errori**.
- Pest `Modules/Lang/tests/Feature` su scratch DB: **10 pass, 13 fail** (errore `user_id` UUID in colonna bigint, vedi [P1-3](../bmad/audits/lang-audit.md#p1-3--test-copertura-inseguita-e-suite-non-verde-su-scratch-db)).

## Anti-pattern vietati

- baseline/`@phpstan-ignore` senza motivazione
- test svuotati per silenziare errori
- `migrate:fresh` / `RefreshDatabase` / `--force`
- docs con date nel nome file
- comportamento o screenshot inventati

### Stato misurato

`migrate:fresh`: 0; `RefreshDatabase`: 0; `@phpstan-ignore`: 0; `dd()`: 0; `->label()` letterali: 2 (`LocaleSwitcherRefresh.php:34,45`).

## Riferimenti

- [00-index](./00-index.md)
- [BMAD audit](../bmad/audit.md)
