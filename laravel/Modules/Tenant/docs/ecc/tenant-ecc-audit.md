---
title: "Audit ECC — Tenant"
type: ecc-audit
status: review
updated: 2026-11-16
module: Tenant
qmd: "ECC audit Tenant verification security testing laravel php-reviewer security-reviewer database-reviewer architect tenant isolation Host TrustHosts policy password"
---

# Audit ECC — Tenant

Mappa finding → capability ECC. Dettaglio: [../bmad/audits/tenant-audit.md](../bmad/audits/tenant-audit.md). Indice: [00-index.md](./00-index.md).

## Contratto PTVX

ECC non sostituisce AGENTS.md/BMAD. Ogni finding: story BMAD, lock, fix causa,
PHPStan + Pest, aggiornamento docs/QMD.

## Finding per capability

| Capability ECC | Esito | Finding | Azione |
|---|---|---|---|
| `security-reviewer` | 3 P1 | TEN-P1-01 Host non fidato; TEN-P1-02 bypass `tenant::admin`; TEN-P1-03 password in chiaro | Epic A, B, C |
| `php-reviewer` | OK | `strict_types` ovunque, 0 raw SQL, 0 label hardcoded, PHPStan 0 | — |
| `database-reviewer` | P2 | `tenant_id` senza FK né global scope su settings/subscriptions; colonna password `string` | Epic C, D (migrazioni solo additive) |
| `architect` | P2 | `SushiToJson` vs `SushiToJsons` duplicati; test in namespace di produzione; due model `Tenant` (Tenant/User) | Epic D |
| `doc-updater` | P2 | 18 collisioni di maiuscole, 40 citazioni di `TenantService::` inesistente | Epic E |
| `tdd-guide` | P2 | nessun test sul perimetro `tenant::admin`; 10 test "coverage" | Epic B |

## Checklist

- [ ] `clean-code`: DRY/KISS, Actions su Services, niente wrapper inutili
- [ ] `security-review`: policy, mass assignment, export, log, privacy, tenant
- [ ] `laravel-verification`: route, config, migration additive, container
- [ ] `verification-loop`: PHPStan level max + Pest mirato
- [ ] `tdd-workflow`: regressione sui finding P1
- [ ] `documentation-sync`: story + indici + qmd
- [ ] `context-engineering`: QMD/graphify prima; registrare il perché dopo

## Input misurato (2026-11-16)

| Voce | N |
|---|---:|
| app PHP | 56 |
| test | 65 |
| resources | 1 |
| actions | 19 |
| services | 0 |
| policy | 2 |

## Gate

- PHPStan `Modules/Tenant`: 0 errori (2026-11-16).
- Pest: skip documentato (DB test non raggiungibile, bootstrap bloccato). Nessun comando distruttivo.

## Regole PTVX applicate

Azioni al posto dei service, base Xot, nessuna label hardcoded, array PHP una chiave per riga, dati sacri (solo migrate additivo).

## Anti-pattern vietati

- baseline/`@phpstan-ignore` senza motivazione
- test svuotati per silenziare errori
- migrate:fresh / RefreshDatabase / --force
- docs con date nel nome file
- comportamento o screenshot inventati

## Riferimenti

- [00-index](./00-index.md)
- [BMAD audit](../bmad/audit.md)
