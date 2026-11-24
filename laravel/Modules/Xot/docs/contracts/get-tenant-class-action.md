---
title: "GetTenantClassAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Xot\\GetTenantClassAction"
qmd: "GetTenantClassAction classe tenant Tenant::class XotService sostituto"
---

# GetTenantClassAction

Restituisce la classe del modello Tenant. Sostituisce `Modules\Xot\Services\XotService::getTenantClass()`. Codice: `app/Actions/Xot/GetTenantClassAction.php` (classe a riga 16, `execute()` a riga 21).

## Input

- Nessuno.

## Output

- `class-string<Model>`: sempre `Tenant::class`.

## Invarianti

- `GET-TENANT-CLASS-INV-1` — Il valore è sempre `Tenant::class`, senza lettura di configurazione. Test: nessuno.

## Effetti collaterali

Nessuno.

## Errori

- Nessuno.

## Non fa

- Non risolve il tenant dal contesto né dalla configurazione.
- Duplica `XotAction::getTenantClass()`.
