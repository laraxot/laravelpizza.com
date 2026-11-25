---
title: "ECC — indice operativo UI"
type: index
status: in-progress
updated: 2026-11-16
module: UI
qmd: "ECC indice UI verification gates esito"
---

# ECC — modulo UI

Collega le verifiche ECC al workflow PTVX (BMAD → lock → fix → PHPStan/Pest → docs).

| Controllo | Stato | Evidenza |
|---|---|---|
| Inventario statico | verificato (2026-11-16) | [audit](../bmad/audits/ui-audit.md) |
| PHPStan `Modules/UI` | 0 errori | `phpstan analyse Modules/UI` (17:07) |
| Pest | skip documentato | DB test `10.100.200.53` irraggiungibile + `TestDatabaseGuard` |
| Security review | aperto | P2-UI4: `UiBasePolicy` senza abilità (nessuna Resource oggi → nessuna esposizione) |
| Docs pack | aggiornato | audit, epics, decision-log, brainstorming, story |

Dettaglio: [ui-ecc-audit.md](./ui-ecc-audit.md)
