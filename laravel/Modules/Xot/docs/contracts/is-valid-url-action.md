---
title: "IsValidUrlAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Url\\IsValidUrlAction"
qmd: "IsValidUrlAction validazione URL filter_var FILTER_VALIDATE_URL sostituisce UrlService"
---

# IsValidUrlAction

Verifica sintatticamente una stringa come URL con `filter_var`.

Codice: `app/Actions/Url/IsValidUrlAction.php:12-20`.

## Input

- `string $url`.

## Output

`bool`: `true` se `filter_var(..., FILTER_VALIDATE_URL)` non è `false`.

## Invarianti

- `URL-VALID-INV-1`: il risultato è `true` solo quando `filter_var` accetta la stringa; nessuna normalizzazione (riga 18). Test: tests/Unit/Actions/Url/IsValidUrlActionTest.php:10 e :17.

## Effetti collaterali

Nessuno.

## Errori

Nessuna eccezione: la stringa non valida produce `false`.

## Non fa

- Non verifica che l'host risponda.
- Non limita lo schema: accetta ciò che `filter_var` accetta come URL (da verificare per schemi diversi da http/https).
