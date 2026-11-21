---
title: "ECC — indice operativo Lang"
type: index
status: in-progress
updated: 2026-11-16
module: Lang
qmd: "ECC indice Lang stato controlli verification gates PHPStan Pest security"
---

# ECC — modulo Lang

Collega le verifiche ECC al workflow PTVX (BMAD → lock → fix → PHPStan/Pest → docs).

| Controllo | Stato | Evidenza |
|---|---|---|
| Inventario statico | verificato (2026-11-16) | [audit profondo](../bmad/audits/lang-audit.md) |
| PHPStan `Modules/Lang` | **0 errori**; 0 anche sul tree `Modules` (2026-11-16) | comando in audit |
| Pest | parziale: `tests/Feature` 10 pass / 13 fail | [audit § Gate](../bmad/audits/lang-audit.md#gate) |
| Security review | nessun P0/P1; P2 su `GetTransPathAction` | [finding](../bmad/audits/lang-audit.md#finding) |
| Docs pack | aggiornato (gap-fill) | [audit](../bmad/audit.md), [epics](../bmad/epics.md), [architecture](../bmad/architecture.md) |

Dettaglio: [lang-ecc-audit.md](./lang-ecc-audit.md)
