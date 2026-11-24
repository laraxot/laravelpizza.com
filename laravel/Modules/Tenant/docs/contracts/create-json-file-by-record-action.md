---
<<<<<<< .merge_file_IDeU2e
title: "CreateJsonFileByRecordAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Json\\CreateJsonFileByRecordAction"
qmd: "CreateJsonFileByRecordAction creazione record file JSON tenant sushi id max timestamp"
=======
title: "Contratto — CreateJsonFileByRecordAction"
type: contract
action: "Modules\Tenant\Actions\Json\CreateJsonFileByRecordAction"
tags: [contract, action, tenant, sushi, json]
created: 2026-11-24
updated: 2026-11-24
>>>>>>> .merge_file_ffW6DS
---

# CreateJsonFileByRecordAction

<<<<<<< .merge_file_IDeU2e
Aggiunge al file JSON del tenant la riga del record nuovo. Codice: `app/Actions/Json/CreateJsonFileByRecordAction.php:22-48`.

## Input

- `Model&HasSushiToJson $record`: record nuovo, senza chiave assegnata.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `CREATE-JSON-INV-1` | L'id nuovo è `max(0, id esistenti) + 1`; con il massimo cancellato, l'id viene riusato. | righe 35-40 | `tests/Unit/Actions/CreateJsonFileByRecordActionStringIdTest.php` |
| `CREATE-JSON-INV-2` | `created_at` e `updated_at` valgono `now()`. | righe 30-31 | `tests/Unit/Actions/Json/JsonFileByRecordActionsTest.php` |
| `CREATE-JSON-INV-3` | Il file viene riscritto come lista, con le chiavi dello schema garantite. | righe 42-47 | `tests/Unit/Actions/Json/JsonFileByRecordActionsTest.php` |

## Effetti collaterali

Ordine: lettura righe, `setAttribute` su timestamp e id (il record viene modificato), `EnsureKeysAction`, `SaveArrayAction` sul file. Nessuna transazione, nessun lock, nessun evento dell'Action.

## Errori

- Le eccezioni di `SaveArrayAction` si propagano.

## Non fa

- Non valida gli attributi.
- Due creazioni concorrenti possono ottenere lo stesso id: non c'è lock.
- Non garantisce id monotoni.
=======
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
>>>>>>> .merge_file_ffW6DS
