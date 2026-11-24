---
title: "XotAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\XotAction"
qmd: "XotAction tenant classe getTenantClass Tenant duplicato GetTenantClassAction"
---

# XotAction

Contenitore con `getTenantClass()`. Codice: `app/Actions/XotAction.php` (classe a riga 15, `execute()` a riga 23 vuoto).

## Input

- Nessuno.

## Output

- `getTenantClass()`: `class-string<Model>`, sempre `Tenant::class`.

## Invarianti

- `XOT-ACTION-INV-1` — `getTenantClass()` restituisce sempre `Tenant::class`. Test: nessuno.

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Duplica `Xot/GetTenantClassAction`, che fa lo stesso. Da unificare.
- `execute()` è vuoto.
