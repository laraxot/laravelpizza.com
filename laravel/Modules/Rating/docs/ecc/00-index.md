---
title: "ECC — indice operativo Rating"
type: index
status: in-progress
updated: 2026-11-16
module: Rating
qmd: "ECC indice Rating verification gates PHPStan Pest skip finding P1"
---

# ECC — modulo Rating

Collega le verifiche ECC al workflow PTVX (BMAD → lock → fix → PHPStan/Pest → docs).

| Controllo | Stato | Evidenza |
|---|---|---|
| Inventario statico | verificato 2026-11-16 | [rating-audit.md](../bmad/audits/rating-audit.md) |
| PHPStan `Modules/Rating` | **0 errori** (level max) | comando in audit |
| Pest | **skip documentato** (timeout, DB test irraggiungibile) | [rating-audit.md](../bmad/audits/rating-audit.md#gate-2026-11-16) |
| Security review | nessun P0; 2 P1 su integrità dati | [rating-ecc-audit.md](./rating-ecc-audit.md) |
| Docs pack | aggiornato | [00-index BMAD](../bmad/00-index.md) |

Dettaglio: [rating-ecc-audit.md](./rating-ecc-audit.md)
