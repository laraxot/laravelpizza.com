---
title: "IsUserDatabaseConfiguredAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Database\\IsUserDatabaseConfiguredAction"
qmd: "IsUserDatabaseConfiguredAction connessione user database configurato DB_DATABASE_USER audit login skip"
---

# IsUserDatabaseConfiguredAction

Dice se la connessione `user` ha un database configurato, senza aprirla. Codice: `app/Actions/Database/IsUserDatabaseConfiguredAction.php:23-33`.

## Input

- Nessuno: legge `database.connections.user.database`.

## Output

- `bool`: `true` se il valore è una stringa non vuota dopo `trim` (riga 31).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `USER-DB-CONFIGURED-INV-1` | Non apre la connessione né interroga lo schema. | righe 27-32 | `tests/Unit/Actions/Database/IsUserDatabaseConfiguredActionTest.php` (riferimento alla classe) |
| `USER-DB-CONFIGURED-INV-2` | Un valore non stringa o vuoto dà `false`. | riga 31 | come sopra |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione.

## Non fa

- Non verifica che il database sia raggiungibile né che la tabella esista.
