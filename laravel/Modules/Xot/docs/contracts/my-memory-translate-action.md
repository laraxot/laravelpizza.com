---
title: "MyMemoryTranslateAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Translation\\MyMemoryTranslateAction"
qmd: "MyMemoryTranslateAction stub traduzione MyMemory restituisce stringa vuota"
---

# MyMemoryTranslateAction

Provider di traduzione MyMemory: implementazione stub che restituisce sempre stringa vuota.

Codice: `app/Actions/Translation/MyMemoryTranslateAction.php:7-12`.

## Input

- `string $text`, `string $from`, `string $to`: ignorati.

## Output

`string`: sempre `''`.

## Invarianti

- `TRANS-MYM-INV-1`: ritorna sempre stringa vuota, qualunque input (riga 11). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

Nessuna eccezione.

## Non fa

- Non traduce: il testo viene perso senza errore. Stub da implementare o da rimuovere.
- Non invoca alcun servizio HTTP né legge chiavi API.
