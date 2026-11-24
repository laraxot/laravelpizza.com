---
title: "GetStrBetweenStartsWithAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\String\\GetStrBetweenStartsWithAction"
qmd: "GetStrBetweenStartsWithAction estrae sottostringa bilanciata apertura chiusura start open close"
---

# GetStrBetweenStartsWithAction

Estrae da `$body` il blocco che inizia alla prima occorrenza di `$start` e si chiude quando il numero di `$open` eguaglia quello di `$close`. Codice: `app/Actions/String/GetStrBetweenStartsWithAction.php`.

## Input

- `string $body`: testo sorgente.
- `string $start`: marcatore iniziale (prima occorrenza).
- `string $open`, `string $close`: delimitatori da bilanciare.

## Output

- `string`: sottostringa da `$start` alla prima lunghezza in cui i conteggi di `$open` e `$close` coincidono.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `STR-BETWEEN-INV-1` | Se `$start` non compare in `$body` lancia `\Exception`. | `tests/Unit/Actions/String/GetStrBetweenStartsWithActionTest.php` (riferisce la classe) |
| `STR-BETWEEN-INV-2` | Il risultato inizia sempre dalla prima occorrenza di `$start`. | `tests/Unit/Actions/String/GetStrBetweenStartsWithActionTest.php` (riferisce la classe) |
| `STR-BETWEEN-INV-3` | Funzione pura: nessuno stato né I/O. | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- `\Exception` quando `$start` manca. Il messaggio include l'intero `$body`, che può finire nei log.
- Se `$close` non compare dopo `$start`, `mb_strpos` restituisce `false` e il calcolo della lunghezza iniziale non è gestito esplicitamente: comportamento da verificare con un test.

## Non fa

- Non verifica che `$close` esista.
- Non gestisce più blocchi o nidificazioni oltre il conteggio globale.
