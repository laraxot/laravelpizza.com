---
title: "ECC audit operativo — Activity"
type: ecc-audit
status: review
updated: 2026-11-16
module: Activity
qmd: "ECC audit Activity checklist security-review clean-code verification-loop inventario misurato finding"
related:
  - ./00-index.md
  - ../bmad/audits/activity-audit.md
  - ../bmad/audit.md
---

# ECC audit operativo — Activity

## Contratto PTVX

ECC non sostituisce `AGENTS.md`/BMAD. Ogni finding: story BMAD, lock, fix alla causa,
PHPStan + Pest, aggiornamento docs/QMD. Dettaglio dei finding: [audit profondo](../bmad/audits/activity-audit.md).

## Checklist (stato misurato 2026-11-16)

| Skill ECC | Stato | Evidenza |
|---|---|---|
| `clean-code` | **parziale** | 0 Services, 0 label hardcoded; duplicati: 2× `ActivityRecorderContract`, 2× `ActivityLogger`, `ActivityBasePolicy` orfana |
| `security-review` | **aperto** | P1-2 registro mutabile da UI; P1-3 segreti non redatti (latente); P1-1 login non loggato |
| `laravel-verification` | **parziale** | migration: 5 `create_activity_table` + `fix_*` vs contratto "unica"; `_bak/` con `dropColumn`; `TestModel` in prod |
| `verification-loop` | **PHPStan ok / Pest vedi sotto** | PHPStan 0; Pest: parziale (25 pass in 2 probe; suite completa in timeout a 900 s) |
| `tdd-workflow` | **aperto** | 8 test file vuoti, 19 skip, 0 `Livewire::test` |
| `documentation-sync` | **parziale** | pack BMAD aggiornato; 331/782 `.md` senza frontmatter; 8 `.md` alla root del modulo |
| `context-engineering` | ok | QMD/graphify prima, decision-log dopo |

## Inventario misurato

| Voce | N |
|---|---:|
| app PHP | 92 |
| test PHP / `*Test.php` / casi Pest | 152 / 100 / 486 |
| Models / Policy / Resource | 5 / 4 / 3 |
| Pagine standalone / pagine Resource / Widget | 5 / 10 / 0 |
| Actions / Services | 30 / 0 |
| Migration (top-level / `_bak`) | 9 / 7 |
| Lang IT | 19 |
| `return true` in Policy (solo `before()`) | 2 |
| `@phpstan-ignore` | 1 |
| Marker conflitto | 0 |

## Gate osservati

- PHPStan `Modules/Activity` (`--no-progress`): **0 errori**.
- Pest `Modules/Activity/tests` su scratch DB (`bashscripts/tools/pest-scratch-db.sh`): **parziale** — suite completa non terminata (timeout 900 s, macchina con load ≈ 50; 16 pass e 40 ⨯ al momento dello stop, **non riproducibili in isolamento**: `BaseModelBusinessLogicTest` 21 pass); probe `ActivityManagementTest` 4 pass. Causa dei ⨯ del run completo non determinata.

## Anti-pattern vietati (verificati assenti)

`migrate:fresh`, `RefreshDatabase`, `--force`: 0 usi. Baseline PHPStan: assente. `@phpstan-ignore` senza motivo: **1** (`Traits/HasSnapshots.php:7`).
Test svuotati per silenziare: **8 file** (vedi P1-4).

## Riferimenti

- [00-index](./00-index.md)
- [BMAD audit](../bmad/audit.md)

## Confine Folio (ECC)

Activity **non** chiama `Folio::path`. File `pages/` sì, mount no.
Owner mount: `Cms/FolioVolt` (FO); progetti senza Cms → niente surrogato in Activity/App.
Story: [folio-routing-centralization](../bmad/stories/folio-routing-centralization.story.md).
