---
title: "Audit BMAD — Tenant"
type: audit
status: review
updated: 2026-11-16
module: Tenant
qmd: "audit BMAD Tenant sintesi Host header TrustHosts tenant admin bypass DatabaseConfig password PHPStan Pest skip"
---

# Audit BMAD — Tenant

SSoT dettagliata: [audits/tenant-audit.md](./audits/tenant-audit.md). Questo file è solo la sintesi.

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
| PHP `app/` | 56 |
| Test | 65 |
| Resources | 1 |
| Actions | 19 |
| Services | 0 |
| Policy `return true` | 2 |
| Marker | 0 |

## Lo scopo in una frase **Tenant permette a una sola installazione di servire piu' enti senza che nessuno veda i dati dell'altro, e di farlo cambiando configurazione invece che codice.**

## Gate

- PHPStan modulo / `Modules`: 0 errori (verifica 2026-11-16).
- Pest: da eseguire in ambiente testing non produttivo.
- Security/runtime: story figlie su finding P0/P1 dell'audit dettagliato.
| Test (file PHP / `*Test.php`) | 65 / 45 |
| Models top-level | 10 |
| Resource / Actions / Services / Policy | 1 / 19 / 0 / 2 |
| Migration | 3 |
| Marker conflitto | 0 |
| P0 / P1 / P2 | 0 / 3 / 9 |
| Policy `return true` | 2 |

## Lo scopo in una frase

**Tenant permette a una sola installazione di servire più enti senza che nessuno veda i dati dell'altro, e di farlo cambiando configurazione invece che codice.**

## Top finding

1. **TEN-P1-01** — tenant scelto da `SERVER_NAME`/`Host` con `TrustHosts` non attivo ([GetTenantNameAction.php:114-148](../../app/Actions/GetTenantNameAction.php)).
2. **TEN-P1-02** — `tenant::admin` aggira ogni policy, delete compresi ([TenantBasePolicy.php:14-22](../../app/Models/Policies/TenantBasePolicy.php)).
3. **TEN-P1-03** — `DatabaseConfig.password` in chiaro, senza cast `encrypted` né `$hidden`.

## Gate

- PHPStan `Modules/Tenant`: **0 errori** (level max, 2026-11-16).
- Pest: **skip documentato** (bootstrap bloccato, DB test `10.100.200.53` non raggiungibile); da eseguire in ambiente testing non produttivo.
- Security/runtime: story figlie sui finding P1 dell'audit dettagliato.

## Riferimenti

[ECC](../ecc/tenant-ecc-audit.md) · [epics](./epics.md) · [story](./stories/module-bmad-audit.story.md)
