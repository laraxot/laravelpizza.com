---
title: "GetProviderButtonsAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Socialite\\GetProviderButtonsAction"
qmd: "GetProviderButtonsAction pulsanti provider socialite segnaposto lista vuota"
---

# GetProviderButtonsAction

Dovrebbe restituire i pulsanti di login per i provider. Oggi restituisce sempre una lista vuota. Codice: `app/Actions/Socialite/GetProviderButtonsAction.php`.

## Input

- Nessuno.

## Output

- `array<int, never>`: sempre `[]`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SOCIALITE-BUTTONS-INV-1` | Il risultato è sempre vuoto. | `execute()` | `tests/Unit/Actions/Socialite/SocialiteUtilityActionsTest.php:114` |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione.

## Non fa

- Non genera pulsanti: è un segnaposto. Nessun chiamante in produzione nel perimetro cercato.
