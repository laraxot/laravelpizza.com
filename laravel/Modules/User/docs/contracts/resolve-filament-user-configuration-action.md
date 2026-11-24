---
title: "ResolveFilamentUserConfigurationAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Shield\\ResolveFilamentUserConfigurationAction"
qmd: "ResolveFilamentUserConfigurationAction filament_user ruolo utente Filament Shield FilamentShieldData"
---

# ResolveFilamentUserConfigurationAction

Riassume la configurazione del ruolo "filament user" di Shield, leggendola da `FilamentShieldData`. Codice: `app/Actions/Shield/ResolveFilamentUserConfigurationAction.php`.

## Input

- Nessuno.

## Output

- `array{enabled: bool, name: string}`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-FILAMENT-USER-INV-1` | `enabled` è `false` se la proprietà manca o è null. | `execute()`, `?? false` | nessuno |
| `SHIELD-FILAMENT-USER-INV-2` | `name` vale `'Filament User'` se la proprietà manca. | `execute()`, `?? 'Filament User'` | nessuno |

## Effetti collaterali

Nessuno: sola lettura del Data.

## Errori

- Nessuna eccezione propria.

## Non fa

- I metodi `toBoolean()` e `toString()` sono identità con tipo: non aggiungono controllo.
- Non è stato riletto `FilamentShieldData` (sorgente dei valori): fuori da questo contract.
- Nessun chiamante in produzione trovato nel perimetro cercato.
