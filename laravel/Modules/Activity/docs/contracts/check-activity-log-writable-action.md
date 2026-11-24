---
title: "Contratto — CheckActivityLogWritableAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Schema\\CheckActivityLogWritableAction"
qmd: "contract CheckActivityLogWritableAction activity log tabella scrivibile colonna attribute_changes connessione schema ACT-SCHEMA-CHK"
---

# CheckActivityLogWritableAction

Dice se la tabella del log attività esiste ed è nello schema atteso (colonna `attribute_changes`). Logica uguale a `IsActivityLogSchemaWritableAction`, con risoluzione di connessione e tabella in metodi separati.

## Input

- Nessuno. Legge `activitylog.enabled`, `activitylog.database_connection`, `activitylog.table_name`, `database.default`.

## Output

- `bool`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-SCHEMA-CHK-INV-1` | Con `activitylog.enabled` falso restituisce `false` senza interrogare lo schema. | Test: nessuno (`CheckActivityLogWritableAction` non ha test dedicati) |
| `ACT-SCHEMA-CHK-INV-2` | Restituisce `true` solo se la tabella esiste e ha la colonna `attribute_changes`, sulla connessione risolta. | Test: nessuno |
| `ACT-SCHEMA-CHK-INV-3` | Connessione vuota o non stringa: si usa `database.default`, o `mysql`. Tabella vuota: `activity_log`. | Test: nessuno |

## Effetti collaterali

Sola lettura dello schema (`hasTable`, `hasColumn`). Nessuna scrittura.

## Errori

- Nessuno dichiarato; errori di connessione si propagano.

## Non fa

- Nessun chiamante di produzione trovato: il lavoro è svolto da `IsActivityLogSchemaWritableAction`. Candidato alla rimozione o al consolidamento (vedi report).

