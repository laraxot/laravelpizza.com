---
title: "SaveTenantConfigAction — contratto"
type: contract
action: "Modules\\Tenant\\Actions\\Config\\SaveTenantConfigAction"
owner: Tenant
status: accepted
updated: 2026-11-24
qmd: "SaveTenantConfigAction persistenza config tenant merge ricorsivo liste sortRecursive SaveArrayAction"
---

# SaveTenantConfigAction

Persiste un file di configurazione del tenant corrente fondendo i dati nuovi con quelli esistenti. Codice: `app/Actions/Config/SaveTenantConfigAction.php:12-73`.

## Input

- `string $name`: nome del file di config senza estensione (diventa `<name>.php`).
- `array<string, mixed> $data`: chiavi da scrivere.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente (senza group) |
|---|---|---|---|
| `TENANT-SAVE-INV-1` | Il file è sempre risolto con `GetTenantFilePathAction` (stesso controllo anti-traversal e stesso isolamento per tenant). | riga 21 | `tests/Unit/Actions/Config/SaveTenantConfigActionTest.php` |
| `TENANT-SAVE-INV-2` | Le chiavi esistenti non presenti in `$data` sono conservate; gli array associativi si fondono ricorsivamente. | righe 23-36, 50-72 | `tests/Unit/Actions/Config/SaveTenantConfigActionTest.php:15,52` |
| `TENANT-SAVE-INV-3` | Una lista (`array_is_list`) sostituisce per intero la vecchia: gli elementi rimossi non ricompaiono. | righe 55-57, 68 | `tests/Unit/Actions/Config/SaveTenantConfigActionTest.php:76` |
| `TENANT-SAVE-INV-4` | Il risultato è ordinato ricorsivamente per chiave prima di essere scritto. | riga 37 | non individuato |

## Effetti collaterali

Legge il file esistente con `File::getRequire` (esegue il PHP del file di config) e lo riscrive con `SaveArrayAction`. Nessuna transazione, nessun evento, nessuna coda. La config in memoria (`Config`) non è aggiornata dall'Action.

## Errori

- `InvalidArgumentException` se `$name.'.php'` viola le regole di percorso (da `GetTenantFilePathAction`).
- Gli errori di scrittura di `SaveArrayAction` si propagano.

## Non fa

- Non cancella chiavi: un valore si rimuove solo sovrascrivendolo.
- Non valida il contenuto dei valori né aggiorna la cache di configurazione.
- Non gestisce concorrenza tra scritture dello stesso file.
