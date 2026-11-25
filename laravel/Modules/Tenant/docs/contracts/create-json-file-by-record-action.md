---
title: "Contratto — CreateJsonFileByRecordAction"
type: contract
action: "Modules\Tenant\Actions\Json\CreateJsonFileByRecordAction"
tags: [contract, action, tenant, sushi, json]
created: 2026-11-24
updated: 2026-11-24
---

# CreateJsonFileByRecordAction

Sorgente: `app/Actions/Json/CreateJsonFileByRecordAction.php`. Gemelle: `UpdateJsonFileByRecordAction`,
`DeleteJsonFileByRecordAction` (stessa chiave `($keyName, $key)`).

## Input

- `Model&HasSushiToJson $record`: il record da aggiungere, non ancora salvato.

## Output

- `void`; il record riceve `id`, `created_at`, `updated_at`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-JSON-CREATE-INV-1 | Nuovo id = max(id numerici esistenti) + 1; gli id stringa numerici (`"11"`) valgono come interi, quelli non numerici come 0. | `TENANT-JSON-CREATE-INV-1` |
| TENANT-JSON-CREATE-INV-2 | File senza righe = id 1, nessuna `ValueError` da `max()`. | `TENANT-JSON-CREATE-INV-2` |
| TENANT-JSON-CREATE-INV-3 | Ogni riga scritta ha tutte le chiavi di `getSchema()` (`EnsureKeysAction`), le righe esistenti restano. | — |

## Effetti collaterali

- Riscrive per intero `$record->getJsonFile()` (JSON del tenant, o la copia di test: vedi `GetTenantFilePathAction`).

## Errori

- Errori di scrittura del filesystem si propagano.

## Non fa

- **Non è chiamata dal trait `SushiToJson`**: il trait ha i propri handler `creating`/`updating`/`deleting` in
  `bootSushiToJson()`, con un calcolo dell'id simile ma non identico (considera anche il max della tabella in memoria).
  Oggi le tre Action Json non hanno chiamanti in produzione: prima di usarle o toglierle, allineare il trait.
- Non gestisce scritture concorrenti né lock del file.
