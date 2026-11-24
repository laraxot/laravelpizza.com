---
title: "GetLoginHistoryAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Login\\GetLoginHistoryAction"
qmd: "GetLoginHistoryAction storico accessi bucket giorno mese authentication_logs Pulse granularity max bucket"
---

# GetLoginHistoryAction

Serie storica degli accessi, bucket per giorno o per mese, letta da `authentication_logs`. Codice: `app/Actions/Login/GetLoginHistoryAction.php:23-113`.

## Input

- `?CarbonImmutable $since`: inizio della serie; se nullo parte dal giorno del primo log (righe 46-55).
- `string $granularity`: `day` o `month` (riga 36).

## Output

- `array{labels: list<string>, data: list<int>}`: un bucket per giorno o mese fino a ora, con zeri dove non ci sono accessi (righe 90-110).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `LOGIN-HIST-INV-1` | Granularità diverse da `day` e `month` sono rifiutate con `InvalidArgumentException`. | righe 36-40 | `tests/Feature/Actions/GetLoginHistoryActionTest.php` (riferimento alla classe) |
| `LOGIN-HIST-INV-2` | Sono contate tutte le righe con timestamp valorizzato, anche con `login_successful` false. | righe 61-71, docblock righe 17-19 | come sopra |
| `LOGIN-HIST-INV-3` | I bucket sono continui: ogni giorno o mese tra inizio e ora compare, anche se vuoto. | righe 90-110 | come sopra |
| `LOGIN-HIST-INV-4` | Oltre 5000 bucket l'Action lancia `InvalidArgumentException` (il messaggio cita solo il giorno, ma il limite vale per entrambe le granularità). | righe 91-96 | come sopra |

## Effetti collaterali

Sola lettura: un `min()` (se `since` manca) e un `pluck()` sul timestamp. Nessuna scrittura.

## Errori

- `InvalidArgumentException` per granularità non valida, configurazione non valida (ereditata da `ResolvesLoginLogQuery`) e serie oltre 5000 bucket.

## Non fa

- Non aggrega in SQL: la scansione è in PHP (commento ponytail righe 59-60).
- Non filtra per esito del login.
- Non usa il fuso di `user.login-monitoring.timezone`: i bucket sono sul timestamp UTC della colonna.
