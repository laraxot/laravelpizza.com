---
title: "GoogleTranslateAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Translation\\GoogleTranslateAction"
qmd: "GoogleTranslateAction stub traduzione Google restituisce stringa vuota"
---

# GoogleTranslateAction

Provider di traduzione Google: implementazione stub che restituisce sempre stringa vuota.

Codice: `app/Actions/Translation/GoogleTranslateAction.php:7-12`.

## Input

- `string $text`, `string $from`, `string $to`: ignorati.

## Output

`string`: sempre `''`.

## Invarianti

- `TRANS-GOOG-INV-1`: ritorna sempre stringa vuota, qualunque input (riga 11). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

Nessuna eccezione.

## Non fa

- Non traduce: il testo viene perso senza errore. Stub da implementare o da rimuovere.
- Non invoca alcun servizio HTTP né legge chiavi API.
