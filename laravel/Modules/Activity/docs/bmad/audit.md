---
title: "Audit BMAD — Activity"
type: audit
status: review
updated: 2026-11-16
module: Activity
qmd: "audit BMAD Activity sintesi gate P1 audit trail append-only LoginListener PII test vuoti"
related:
  - ./audits/activity-audit.md
  - ./piano-miglioramento.md
  - ../ecc/activity-ecc-audit.md
---

# Audit BMAD — Activity

SSoT dettagliata (inventario, evidenze `path:line`, non-finding): [audits/activity-audit.md](./audits/activity-audit.md).

**Scopo in una frase:** Activity risponde a "chi ha cambiato cosa, quando e com'era prima" — in una PA è un obbligo ([purpose.md](./purpose.md)).

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
| PHP `app/` / test PHP / file `*Test.php` | 92 / 152 / 100 |
| Resource / Actions / Services / Widget | 3 / 30 / 0 / 0 |
| Policy `return true` (solo `before()`) | 2 |
| Marker conflitto / `RefreshDatabase` | 0 / 0 |
| Test file vuoti / punti di skip | 8 / 19 |

## Finding principali

| # | Sev | Finding |
|---|---|---|
| 1 | P1 | `LoginListener::handle()` vuoto ma registrato; 7 test skip |
| 2 | P1 | Registro mutabile da UI (`EditActivity` + `DeleteAction`, Create/Edit su event store) |
| 3 | P1 | Nessuna redazione segreti: `RedactModelAttributesAction` senza caller; rischio latente |
| 4 | P1 | 8 file test svuotati (corpo perso in `35dbbfe8`) + 19 skip |
| 5 | P1 | 0 test Livewire/pannello; autorizzazione non coperta |
| 6 | P2 | `activity::admin` senza bypass (policy su `UserBasePolicy`), duplicati contratti/logger, `TestModel` in prod, migrazioni vs contratto "unica" |

## Gate

- PHPStan `Modules/Activity`: **0 errori** (2026-11-16).
- Pest: **parziale** — 25 pass in 2 probe (`ActivityManagementTest`, `BaseModelBusinessLogicTest`); suite completa in timeout a 900 s (macchina con load ≈ 50; i 40 ⨯ visti non si riproducono in isolamento). Dopo i fix della [story](./stories/module-bmad-audit.story.md), `tests/Feature` da sola: **0 failed / 181 passed / 9 skipped** (~660 s). Dettaglio in [audit § Gate](./audits/activity-audit.md#gate).
- Pest: **parziale** — 25 pass in 2 probe (`ActivityManagementTest`, `BaseModelBusinessLogicTest`); suite completa in timeout a 900 s (macchina con load ≈ 50; i 40 ⨯ visti non si riproducono in isolamento). Dopo i fix della [story](./stories/module-bmad-audit.story.md), `tests/Feature` da sola: **0 failed / 181 passed / 9 skipped** (~660 s). Dettaglio in [audit § Gate](./audits/activity-audit.md#gate).
- Pest: **parziale** — 25 pass in 2 probe (`ActivityManagementTest`, `BaseModelBusinessLogicTest`); suite completa in timeout a 900 s (macchina con load ≈ 50; i 40 ⨯ visti non si riproducono in isolamento). Dopo i fix della [story](./stories/module-bmad-audit.story.md), `tests/Feature` da sola: **0 failed / 181 passed / 9 skipped** (~660 s). Dettaglio in [audit § Gate](./audits/activity-audit.md#gate).
- Pest: **parziale** — 25 pass in 2 probe (`ActivityManagementTest`, `BaseModelBusinessLogicTest`); suite completa in timeout a 900 s (macchina con load ≈ 50; i 40 ⨯ visti non si riproducono in isolamento).
- Pest: **parziale** — 25 pass in 2 probe (`ActivityManagementTest`, `BaseModelBusinessLogicTest`); suite completa in timeout a 900 s (macchina con load ≈ 50; i 40 ⨯ visti non si riproducono in isolamento). Dopo i fix della [story](./stories/module-bmad-audit.story.md), `tests/Feature` da sola: **0 failed / 181 passed / 9 skipped** (~660 s). Dettaglio in [audit § Gate](./audits/activity-audit.md#gate).
- Security/runtime: le story figlie dei P1 sono in [epics.md](./epics.md).

## Riferimenti

[Piano](./piano-miglioramento.md) · [Epics](./epics.md) · [Decision log](./decision-log.md) · [ECC](../ecc/activity-ecc-audit.md) · [Story](./stories/module-bmad-audit.story.md)
