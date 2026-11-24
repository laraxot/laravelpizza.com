---
<<<<<<< .merge_file_T6nQXM
title: "SaveTenantConfigAction — contratto"
type: contract
action: "Modules\\Tenant\\Actions\\Config\\SaveTenantConfigAction"
owner: Tenant
status: accepted
updated: 2026-11-24
qmd: "SaveTenantConfigAction persistenza config tenant merge ricorsivo liste sortRecursive SaveArrayAction"
=======
title: "Contratto — SaveTenantConfigAction"
type: contract
action: "Modules\Tenant\Actions\Config\SaveTenantConfigAction"
tags: [contract, action, tenant, config]
created: 2026-11-24
updated: 2026-11-24
>>>>>>> .merge_file_H7iNka
---

# SaveTenantConfigAction

<<<<<<< .merge_file_T6nQXM
Persiste un file di configurazione del tenant corrente fondendo i dati nuovi con quelli esistenti. Codice: `app/Actions/Config/SaveTenantConfigAction.php:12-73`.

## Input

- `string $name`: nome del file di config senza estensione (diventa `<name>.php`).
- `array<string, mixed> $data`: chiavi da scrivere.
=======
Sorgente: `app/Actions/Config/SaveTenantConfigAction.php`. Chiamata dalle pagine di impostazioni (es. cluster Appearance
del modulo User, `Modules/Xot/app/Filament/Pages/BaseSettingPage.php`).

## Input

- `$name`: nome del file di config senza estensione (`database`, `xra`, ...).
- `$data`: array da fondere, tipicamente lo stato di un form.
>>>>>>> .merge_file_H7iNka

## Output

- `void`.

## Invarianti

<<<<<<< .merge_file_T6nQXM
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
=======
| ID | Regola | Group Pest |
|---|---|---|
| TENANT-CONFIG-SAVE-INV-1 | Le chiavi associative si fondono in profondità: quelle non inviate restano, quelle inviate vincono. | `TENANT-CONFIG-SAVE-INV-1` |
| TENANT-CONFIG-SAVE-INV-2 | Una lista (`array_is_list`) inviata sostituisce per intero la vecchia: mai fusione per indice. | `TENANT-CONFIG-SAVE-INV-2` |
| TENANT-CONFIG-SAVE-INV-3 | File assente o che non ritorna un array = si parte da `[]` e il file si crea. | `TENANT-CONFIG-SAVE-INV-3` |
| TENANT-CONFIG-SAVE-INV-4 | Il file si scrive sempre in `config/<tenant>/<name>.php` risolto da `GetTenantFilePathAction`, con chiavi ordinate (`Arr::sortRecursive`). | — |

## Effetti collaterali

- Legge il file con `File::getRequire()` ed esegue il PHP che contiene.
- Riscrive il file intero con `Modules\Xot\Actions\Arr\SaveArrayAction` (file versionato del sito).

## Errori

- `InvalidArgumentException` da `GetTenantFilePathAction` se `$name` contiene traversal o è assoluto.
- Errori di scrittura del filesystem si propagano.

## Non fa

- Non ricarica la config in memoria: il valore nuovo si vede dalla richiesta successiva (o con `config([...])` del chiamante).
- Non valida i valori né fa backup del file precedente.
- Non gestisce scritture concorrenti: l'ultima vince.
>>>>>>> .merge_file_H7iNka
