---
title: "IsNotificationSchemaReadableAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Notification\\IsNotificationSchemaReadableAction"
qmd: "IsNotificationSchemaReadableAction tabella notifications connessione User verifica schema front office"
---

# IsNotificationSchemaReadableAction

Verifica che la tabella `notifications` esista sulla connessione del modello prima di interrogarla dal front office. Codice: `app/Actions/Notification/IsNotificationSchemaReadableAction.php:14-30`.

## Input

- Nessuno.

## Output

- `bool`: `hasTable` della tabella del modello `Notification` (riga 28).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `NOTIF-SCHEMA-INV-1` | Se il modello non dichiara connessione si usa la connessione di default (`mysql` se la config non è una stringa). | righe 22-26 | `tests/Unit/UserExecuteCoverage50Test.php` (riferimento alla classe) |
| `NOTIF-SCHEMA-INV-2` | Restituisce solo l'esistenza della tabella, non le colonne. | riga 28 | come sopra |

## Effetti collaterali

Interrogazione dello schema (information_schema). Nessuna scrittura.

## Errori

- Nessuna gestione esplicita: un errore di connessione si propaga.

## Non fa

- Non verifica le colonne né i permessi.
