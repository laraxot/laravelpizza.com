---
title: "TryMailAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Mail\\TryMailAction"
qmd: "TryMailAction prova driver Try{Driver}MailAction IMAP lettura casella test"
---

# TryMailAction

Dispatcher di prova per i driver mail: risolve `Mail\Engines\{Driver}\Try{Driver}MailAction` ed esegue il suo `execute`.

## Input

- `string $to = ''`, `?string $body`, `array $vars`, `?string $from`, `string $driver = 'duocircle'`.

## Output

- `void`: il risultato dell'engine viene scartato.

## Invarianti

- `NOTIFY-TRYMAIL-INV-1`: l'engine e' `Try{Driver}MailAction` (non `Send`). Il nome risolto e' verificato con `Assert::classExists`. Test: nessuno dedicato verificato.
- `NOTIFY-TRYMAIL-INV-2`: come `SendMailAction`, le chiavi stringa di `$vars` diventano proprieta'. Test: nessuno.

## Effetti collaterali

- Dipendono dall'engine: per `duocircle` legge la casella IMAP e sposta i messaggi (vedi `TryDuocircleMailAction`).

## Errori

- `Assert` se la classe engine manca; `RuntimeException` se non ha `execute()`.

## Non fa

- Non restituisce al chiamante il risultato dell'engine.
- Non e' un test di invio: con il driver `duocircle` la sua funzione e' leggere e spostare messaggi.
