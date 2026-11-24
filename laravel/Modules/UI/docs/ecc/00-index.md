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
<<<<<<< HEAD
=======
<<<<<<< .merge_file_7dKKH7
| Inventario statico | verificato | ../bmad/audits/ui-audit.md |
| PHPStan | 0 su tree Modules (2026-11-16) | comando in audit |
| Pest | pending | ambiente testing |
| Security review | pending | story figlie P0/P1 |
| Docs pack | aggiornato | questo indice + audit ECC |
=======
>>>>>>> .merge_file_eWDORp
>>>>>>> laraxot/dev
| Inventario statico | verificato (2026-11-16) | [audit](../bmad/audits/ui-audit.md) |
| PHPStan `Modules/UI` | 0 errori | `phpstan analyse Modules/UI` (17:07) |
| Pest | skip documentato | DB test `10.100.200.53` irraggiungibile + `TestDatabaseGuard` |
| Security review | aperto | P2-UI4: `UiBasePolicy` senza abilità (nessuna Resource oggi → nessuna esposizione) |
| Docs pack | aggiornato | audit, epics, decision-log, brainstorming, story |

Dettaglio: [ui-ecc-audit.md](./ui-ecc-audit.md)
