---
title: "ECC audit operativo — User"
type: ecc-audit
status: review
updated: 2026-11-16
module: User
qmd: "ECC audit User security-review clean-code laravel-verification verification-loop tdd-workflow"
---

# ECC audit operativo — User

## Contratto PTVX

ECC non sostituisce `AGENTS.md`/BMAD: ogni finding diventa story in [epics.md](../bmad/epics.md), con lock,
fix alla causa, PHPStan + Pest, aggiornamento docs/QMD. Le abilità ECC sono scelte on-demand
(`ecc-ptvx-workflow`); qui è registrato **l'esito**, non la checklist vuota.

## Esito per skill (2026-11-16)

| Skill ECC | Stato | Evidenza |
|---|---|---|
| `clean-code` (DRY/KISS, Actions-over-Services) | parziale | classe morta `UserPermissionBasePolicy`; 24 label letterali; 2 `extends` Filament diretti |
| `security-review` (policy, accesso pannello, dati) | P0 aperti | P0-U1/P0-U2 verificati a runtime (script mock): escalation `user::admin` |
| `laravel-verification` (route, policy, migration additive) | parziale | `canAccessPanel` testato (`SecurityCriticalPathsTest`, `AdminPanelAuthenticationTest`); `PermissionPolicy` non testata |
| `verification-loop` (PHPStan max + Pest) | PHPStan ok, Pest skip | PHPStan 0 errori; Pest: skip documentato: DB di test `10.100.200.53:3306` irraggiungibile (TCP chiuso) e `Xot/tests/Support/TestDatabaseGuard.php:63` rifiuta DB non `*_test`; i test con DB restano appesi al connect MySQL (timeout 150 s osservato). Nessun test contro il MySQL locale (dati sacri). |
| `tdd-workflow` (regressione sui P0) | aperto | scrivere prima il Pest rosso su `user::admin` → `RolePolicy::before` (null atteso) |
| `documentation-sync` | fatto | pack aggiornato: [audit](../bmad/audits/user-audit.md), [epics](../bmad/epics.md), [decision-log](../bmad/decision-log.md) |
| `context-engineering` | fatto | source-first; il perché in [purpose](../bmad/purpose.md) |

## Input misurato (2026-11-16)

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

## Finding da trasformare in story

- **P0-U1** `user::admin` scavalca `RolePolicy/PermissionPolicy/TeamPolicy` (before → true, verificato a runtime): escalation — `Xot/app/Models/Policies/XotBasePolicy.php:21; User/app/Models/Policies/RolePolicy.php`
- **P0-U2** `PermissionPolicy` view/create/update/delete = true (solo `viewAny` false) — `User/app/Models/Policies/PermissionPolicy.php:25,33,41,50`
- **P1-U3** 18 policy scrivono su DB durante l'autorizzazione (`hasPermissionToOrCreate`) — `User/app/Models/Traits/HasSpatiePermission.php:14`
- **P1-U4** `restaurant::admin` cablato nel core HR (`canAccessPanel`, `ADMIN_ROLES`) — `User/app/Models/BaseUser.php:~298,~318`

## Anti-pattern vietati

- baseline o `@phpstan-ignore` senza motivazione; test svuotati per silenziare errori;
- `migrate:fresh`, `RefreshDatabase`, `--force` su migrate; `laravel/public` al posto di `public_html`;
- nascondere la navigazione al posto di un controllo di accesso (`canAccess`/policy);
- comportamento, schermate o numeri inventati;
- docs con date nel nome file.

## Riferimenti

- [00-index](./00-index.md) · [BMAD audit](../bmad/audit.md) · [audit dettagliato](../bmad/audits/user-audit.md)
