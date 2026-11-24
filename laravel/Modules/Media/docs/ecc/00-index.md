---
title: "ECC — indice operativo Media"
type: index
status: in-progress
updated: 2026-11-16
module: Media
qmd: "ECC indice Media stato controlli verification gates PHPStan Pest security"
---

# ECC — modulo Media

Collega le verifiche ECC al workflow PTVX (BMAD → lock → fix → PHPStan/Pest → docs).

| Controllo | Stato | Evidenza |
|---|---|---|
| Inventario statico | verificato | ../bmad/audits/media-audit.md |
| PHPStan | 0 su tree Modules (2026-11-16) | comando in audit |
| Pest | pending | ambiente testing |
| Security review | pending | story figlie P0/P1 |
| Docs pack | aggiornato | questo indice + audit ECC |
| Inventario statico | verificato (2026-11-16) | [audit profondo](../bmad/audits/media-audit.md) |
| PHPStan `Modules/Media` | **0 errori** | comando in audit |
| Pest | parziale: `tests/Unit/Models` 49 pass / 1 fail | [audit § Gate](../bmad/audits/media-audit.md#gate) |
| Security review | **aperta** — 0 P0, 3 P1 di sicurezza (6 P1 in tutto) | [finding](../bmad/audits/media-audit.md#finding) |
| Docs pack | aggiornato (gap-fill) | [audit](../bmad/audit.md), [epics](../bmad/epics.md), [architecture](../bmad/architecture.md) |

Dettaglio: [media-ecc-audit.md](./media-ecc-audit.md)
