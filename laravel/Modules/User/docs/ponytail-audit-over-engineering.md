---
title: "Ponytail audit: User (over-engineering)"
type: concept
tags: [ponytail, audit, over, engineering]
created: 2026-07-14
updated: 2026-07-14
qmd: "ponytail-audit-over-engineering ponytail audit: user (over-engineering)"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Ponytail audit: User (over-engineering)

**Ultimo run:** 2026-07-01  
**Modulo:** auth, team, Passport, profili.  
**Hub:** [../../../../docs/audit/ponytail-audit.md](../../../../docs/audit/ponytail-audit.md)  
**Remediation:** [../../../../docs/project/ponytail-audit-remediation.md](../../../../docs/project/ponytail-audit-remediation.md)  
**GitHub monorepo:** [Issue #221](https://github.com/laraxot/base_predict_fila5/issues/221) · [Discussion #222](https://github.com/laraxot/base_predict_fila5/discussions/222) · [Discussion #228](https://github.com/laraxot/base_predict_fila5/discussions/228)

## Findings

| # | Tag | Cosa | Sostituzione | Path |
|---|-----|------|--------------|------|
| U2 | `delete` | 16 contratti Fortify/Jetstream orfani (1 ref = solo definizione) | Widget `getState()` + Action | `app/Contracts/` | ✅ **2026-07-01** |
| U2b | `delete` | `MockUserWithTeams` duplicato fuori `Fixtures/` | Solo `Fixtures/MockUserWithTeams` | `tests/Unit/Models/Traits/` | ✅ |
| U2c | `shrink` | `HasAuthenticationLogTrait` generics `$this` | PHPStan L10 covariant | `app/Models/Traits/` | ✅ |
| U3 | `shrink` | `BaseUser.php` con molti trait | Dopo audit permessi Spatie | `app/Models/BaseUser.php` | aperto |
| U4 | `delete` | ~281 `lang/**/*.backup_*` | `lang/{locale}/*.php.bak` in-place | `lang/` | ✅: [wiki](./wiki/concepts/lang-backup-in-place.md) |

**Contratti rimasti (canonici):** `UserContract`, `TeamContract`, `TenantContract`, `HasTeamsContract`, `HasAuthentications`, `HasShieldPermissions`, `ModelContract`, `PassportHasApiTokensContract`.

## ⛔ Fuori perimetro (non tagliare)

| Area | Motivo |
|------|--------|
| `app/Models/Policies/*Policy.php` | Contratto Laravel/Filament: anche stub su `UserBasePolicy`. Vedi [Job: model-policy-laravel-contract](../../Job/docs/wiki/concepts/model-policy-laravel-contract.md). |

## Vincolo correlato

`spatie/laravel-permission` resta in **Xot** `composer.json`, non rimuovere da lì.

## Collegamenti

- [00-index-1.md](./00-index.md)
- [00-index-1.md](./00-index-indice-documentazione-modulo-user.md)
- [Xot audit](../../Xot/docs/ponytail-audit-over-engineering.md)
