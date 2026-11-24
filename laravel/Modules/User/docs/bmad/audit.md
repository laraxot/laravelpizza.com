---
title: "Audit BMAD — User"
type: audit
status: review
updated: 2026-11-16
module: User
qmd: "audit BMAD User sintesi finding P0 P1 PHPStan Pest"
---

# Audit BMAD — User

SSoT dettagliata: [audits/user-audit.md](./audits/user-audit.md)

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
| PHP `app/` | 713 |
| Test | 233 |
| Resources | 26 |
| Actions | 83 |
| Services | 0 |
| Policy `return true` | 8 |
| Marker | 0 |

## Lo scopo in una frase **User risponde a tre domande e non ad altre: chi sei, cosa puoi fare, per conto di chi. Tutto il resto che si sa di una persona appartiene al dominio, non a User.**

## Gate

- PHPStan modulo / `Modules`: 0 errori (verifica 2026-11-16).
- Pest: da eseguire in ambiente testing non produttivo.
- Security/runtime: story figlie su finding P0/P1 dell'audit dettagliato.
SSoT dettagliata: [audits/user-audit.md](./audits/user-audit.md) · scopo: [purpose.md](./purpose.md)

**In una frase:** chi è chi e cosa può fare: utenti, ruoli, permessi, team, OAuth, accesso ai pannelli.

**Lo scopo:** User risponde a tre domande e non ad altre: chi sei, cosa puoi fare, per conto di chi. Tutto il resto che si sa di una persona appartiene al dominio, non a User.

## Inventario misurato (2026-11-16)

| Voce | N |
|---|---:|
| PHP `app/` | 713 |
| Test PHP | 233 |
| Models | 123 |
| Policy | 39 |
| Resource | 37 (35 file `*Resource.php` ricontati il 2026-11-19) |
| Widget | 31 |
| Actions | 90 (di cui 83 in `app/Actions`, il resto in `app/Filament/**/Actions`) |
| Services | 0 |
| Migration | 83 |
| Lang IT | 264 |
| `->label('..')` letterali | 24 |
| `@phpstan-ignore` | 1 |
| Policy con `return true` | 8 (2026-11-16; ricontati il 2026-11-19: 4 file policy con `return true`) |
| Marker di conflitto | 0 |

## Top finding

- **P0-U1** `user::admin` scavalca `RolePolicy/PermissionPolicy/TeamPolicy` (before → true, verificato a runtime): escalation — `Xot/app/Models/Policies/XotBasePolicy.php:21; User/app/Models/Policies/RolePolicy.php`
- **P0-U2** `PermissionPolicy` view/create/update/delete = true (solo `viewAny` false) — `User/app/Models/Policies/PermissionPolicy.php:25,33,41,50`
- **P1-U3** 18 policy scrivono su DB durante l'autorizzazione (`hasPermissionToOrCreate`) — `User/app/Models/Traits/HasSpatiePermission.php:14`
- **P1-U4** `restaurant::admin` cablato nel core HR (`canAccessPanel`, `ADMIN_ROLES`) — `User/app/Models/BaseUser.php:~298,~318`; `ADMIN_ROLES` in `User/app/Models/Policies/BaseUserPolicy.php:27`

## Gate

- PHPStan `Modules/User`: **0 errori** (17:08).
- Pest: skip documentato: DB di test `10.100.200.53:3306` irraggiungibile (TCP chiuso) e `Xot/tests/Support/TestDatabaseGuard.php:63` rifiuta DB non `*_test`; i test con DB restano appesi al connect MySQL (timeout 150 s osservato). Nessun test contro il MySQL locale (dati sacri).
- Security/runtime: story figlie su finding P0/P1 dell'audit dettagliato.

## Seguito

[epics.md](./epics.md) · [decision-log.md](./decision-log.md) · [story](./stories/module-bmad-audit.story.md) · [piano](./piano-miglioramento.md) · [ECC](../ecc/user-ecc-audit.md)
