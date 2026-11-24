---
title: "Contratto — SaveTenantConfigAction"
type: contract
action: "Modules\Tenant\Actions\Config\SaveTenantConfigAction"
tags: [contract, action, tenant, config]
created: 2026-11-24
updated: 2026-11-24
---

# SaveTenantConfigAction

Sorgente: `app/Actions/Config/SaveTenantConfigAction.php`. Chiamata dalle pagine di impostazioni (es. cluster Appearance
del modulo User, `Modules/Xot/app/Filament/Pages/BaseSettingPage.php`).

## Input

- `$name`: nome del file di config senza estensione (`database`, `xra`, ...).
- `$data`: array da fondere, tipicamente lo stato di un form.

## Output

- `void`.

## Invarianti

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
