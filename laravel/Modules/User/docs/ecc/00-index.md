---
title: "ECC — indice operativo User"
type: index
status: in-progress
updated: 2026-11-16
module: User
qmd: "ECC indice User verification gates esito"
---

# ECC — modulo User

Collega le verifiche ECC al workflow PTVX (BMAD → lock → fix → PHPStan/Pest → docs).

| Controllo | Stato | Evidenza |
|---|---|---|
| Inventario statico | verificato (2026-11-16) | [audit](../bmad/audits/user-audit.md) |
| PHPStan `Modules/User` | 0 errori; 0 anche sul tree `Modules` (2026-11-16) | `phpstan analyse Modules/User` (17:08) |
| Pest | skip documentato | DB test `10.100.200.53` irraggiungibile + `TestDatabaseGuard` |
| Security review | P0 aperti | P0-U1/P0-U2 verificati a runtime (script mock): escalation `user::admin` |
| Docs pack | aggiornato | audit, epics, decision-log, brainstorming, story |

Dettaglio: [user-ecc-audit.md](./user-ecc-audit.md)
