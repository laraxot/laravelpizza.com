---
title: "UpdateJsonFileByRecordAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Json\\UpdateJsonFileByRecordAction"
qmd: "UpdateJsonFileByRecordAction aggiornamento record file JSON tenant chiave primaria UUID upsert"
---

# UpdateJsonFileByRecordAction

Sostituisce nel file JSON del tenant la riga del record modificato. Codice: `app/Actions/Json/UpdateJsonFileByRecordAction.php:22-51`.

## Input

- `Model&HasSushiToJson $record`: record con chiave valorizzata.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `UPDATE-JSON-INV-1` | La riga è identificata da `($keyName, $key)` e sostituita. | righe 37-39 | `tests/Unit/Actions/Json/JsonFileByRecordActionsTest.php` |
| `UPDATE-JSON-INV-2` | La chiave può essere intera o stringa (UUID); bool e float sono rifiutati da `Assert::validArrayKey`. | riga 34 | nessuno dedicato |
| `UPDATE-JSON-INV-3` | Se la chiave non esiste nel file, la riga viene aggiunta (upsert). | riga 39 | nessuno (comportamento da confermare) |
| `UPDATE-JSON-INV-4` | `updated_at` vale `now()`. | riga 30 | `tests/Unit/Actions/Json/JsonFileByRecordActionsTest.php` |

## Effetti collaterali

Ordine: lettura righe, `setAttribute('updated_at')` (modifica il record), chiavizzazione, `EnsureKeysAction`, `SaveArrayAction`. Nessuna transazione, nessun evento dell'Action.

## Errori

- `Assert::validArrayKey` lancia per chiavi non ammesse.
- Le eccezioni di `SaveArrayAction` si propagano.

## Non fa

- Non controlla che la riga esista prima di aggiungerla (vedi INV-3).
