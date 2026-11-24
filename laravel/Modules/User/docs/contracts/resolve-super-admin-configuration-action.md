---
title: "ResolveSuperAdminConfigurationAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Shield\\ResolveSuperAdminConfigurationAction"
qmd: "ResolveSuperAdminConfigurationAction super admin Filament Shield gate intercept_gate define_via_gate"
---

# ResolveSuperAdminConfigurationAction

Riassume la configurazione del super admin di Filament Shield (abilitazione, nome, definizione via gate, stato di intercettazione del gate). Codice: `app/Actions/Shield/ResolveSuperAdminConfigurationAction.php`.

## Input

- Nessuno.

## Output

- `array{enabled: bool, name: string, defined_via_gate: bool, gate_interception_status: string}`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-SUPER-ADMIN-INV-1` | I valori mancanti valgono: `enabled` e `defined_via_gate` `false`, `name` `'Super Admin'`, `gate_interception_status` `'block'`. | `execute()`, operatori `??` | nessuno |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione propria.

## Non fa

- `gate_interception_status` è una stringa libera: non è validata contro un insieme di valori ammessi.
- I metodi `toBoolean()` e `toString()` sono identità con tipo.
- Nessun chiamante in produzione trovato nel perimetro cercato.
