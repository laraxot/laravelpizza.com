---
title: "ECC — indice operativo Activity"
type: index
status: in-progress
updated: 2026-11-16
module: Activity
qmd: "ECC indice Activity stato controlli verification gates PHPStan Pest security"
---

# ECC — modulo Activity

Collega le verifiche ECC al workflow PTVX (BMAD → lock → fix → PHPStan/Pest → docs).

| Controllo | Stato | Evidenza |
|---|---|---|
| Inventario statico | verificato (2026-11-16) | [audit profondo](../bmad/audits/activity-audit.md) |
| PHPStan `Modules/Activity` | **0 errori** | comando in audit |
| Pest | parziale: 25 pass in 2 probe (`ActivityManagementTest`, `BaseModelBusinessLogicTest`); suite completa in timeout (900 s); `tests/Feature` 0 failed / 181 passed / 9 skipped dopo i fix | [audit § Gate](../bmad/audits/activity-audit.md#gate) |
| Security review | **aperta** — 3 P1 (registro mutabile, segreti non redatti, login) | [finding](../bmad/audits/activity-audit.md#finding) |
| Docs pack | aggiornato | [audit](../bmad/audit.md), [piano](../bmad/piano-miglioramento.md), [epics](../bmad/epics.md) |

Dettaglio: [activity-ecc-audit.md](./activity-ecc-audit.md)
