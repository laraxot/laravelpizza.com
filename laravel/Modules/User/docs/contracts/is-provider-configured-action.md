---
title: "IsProviderConfiguredAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\IsProviderConfiguredAction"
qmd: "IsProviderConfiguredAction provider OAuth configurato client_id client_secret redirect booleano"
---

# IsProviderConfiguredAction

Dice se un provider OAuth ha tutte le impostazioni reali. Codice: `app/Actions/Socialite/IsProviderConfiguredAction.php`.

## Input

- `string $provider`.

## Output

- `bool`: `true` se `GetMissingProviderSettingsAction` non ritorna variabili mancanti.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-IS-CONFIGURED-INV-1` | `true` se e solo se la lista delle mancanti è vuota. | `execute()` | `tests/Unit/Actions/Socialite/ProviderSettingsActionsTest.php:65,68` |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non verifica le credenziali presso il provider.
- Nessun chiamante in produzione nel perimetro cercato: `ValidateProviderAction` chiama direttamente `GetMissingProviderSettingsAction`.
