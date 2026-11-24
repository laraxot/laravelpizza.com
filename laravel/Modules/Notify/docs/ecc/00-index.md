---
title: "ECC — indice operativo Notify"
type: index
status: in-progress
<<<<<<< HEAD
updated: 2026-11-16
module: Notify
qmd: "ECC indice Notify verification gates PHPStan Pest security-review"
=======
updated: 2026-11-23
module: Notify
qmd: "ECC indice Notify verification gates PHPStan Pest security-review"
created: 2026-11-23
>>>>>>> laraxot/dev
---

# ECC — modulo Notify

Collega le verifiche ECC al workflow PTVX (BMAD → lock → fix → PHPStan/Pest → docs).

| Controllo | Stato | Evidenza |
|---|---|---|
| Inventario statico | verificato 2026-11-16 | [audit](../bmad/audits/notify-audit.md) |
| PHPStan `Modules/Notify` | **0 errori** | comando in audit |
| Pest | **skip documentato** | MySQL `10.100.200.53:3306` irraggiungibile |
| Security review | 2 P1 aperti | `NotificationLog` senza policy; webhook inbound |
| Docs pack | aggiornato | questo indice + [ECC audit](./notify-ecc-audit.md) |

Backlink: [BMAD audit](../bmad/audit.md) · [indice BMAD](../bmad/index.md)
