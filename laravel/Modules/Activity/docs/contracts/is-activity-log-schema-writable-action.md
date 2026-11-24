---
title: "Contratto — IsActivityLogSchemaWritableAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Schema\\IsActivityLogSchemaWritableAction"
qmd: "contract IsActivityLogSchemaWritableAction activity log schema scrivibile attribute_changes Spatie v4 registrazione utente ACT-SCHEMA-IS"
---

# IsActivityLogSchemaWritableAction

Verifica che la tabella `activity_log` esista e abbia la colonna `attribute_changes`, richiesta da Spatie activitylog v4+. Usata dalla registrazione utente per decidere se scrivere il log.

## Input

- Nessuno. Legge `activitylog.enabled`, `activitylog.database_connection`, `activitylog.table_name`, `database.default`.

## Output

- `bool`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-SCHEMA-IS-INV-1` | Con `activitylog.enabled` falso restituisce `false` senza interrogare lo schema. | `IsActivityLogSchemaWritableActionTest.php` («returns false when activity log is disabled»); `Support/ActivityLogSchemaTest.php` |
| `ACT-SCHEMA-IS-INV-2` | `true` solo se la tabella esiste e ha `attribute_changes` sulla connessione risolta. | Test: nessuno diretto |
| `ACT-SCHEMA-IS-INV-3` | Connessione vuota o non stringa: `database.default`, o `mysql`. Tabella vuota: `activity_log`. | Test: nessuno |

## Effetti collaterali

Sola lettura dello schema. Nessuna scrittura.

## Errori

- Nessuno dichiarato; errori di connessione si propagano.

## Non fa

- Non crea né migra la tabella.
- Duplica la logica di `CheckActivityLogWritableAction` (vedi report).

