---
title: "Contratto — SaveHeadernavConfigAction"
type: contract
action: "Modules\Cms\Actions\SaveHeadernavConfigAction"
tags: [contract, action, cms, appearance, tenant-config]
created: 2026-11-24
updated: 2026-11-24
---

# SaveHeadernavConfigAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/SaveHeadernavConfigAction.php`. Chiamante: pagina Filament
`app/Filament/Clusters/Appearance/Pages/Headernav.php` (salvataggio del form).

## Input

- `HeadernavData`: dati del form headernav (colori, classi, sfondo, ...).

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| CMS-HEADERNAV-SAVE-INV-1 | Scrive solo la chiave `headernav` del file di config `appearance` del tenant, con `HeadernavData::toArray()`, delegando a `Modules\Tenant\Actions\Config\SaveTenantConfigAction`. | `CMS-HEADERNAV-SAVE-INV-1` |
| CMS-HEADERNAV-SAVE-INV-2 | Le altre chiavi di `appearance.php` restano (fusione ricorsiva in `SaveTenantConfigAction`; una lista arriva sempre completa e sostituisce la precedente). | — |

## Effetti collaterali

- Riscrive il file PHP `appearance.php` della cartella di config del tenant corrente (via `SaveTenantConfigAction` e
  `Modules\Xot\Actions\Arr\SaveArrayAction`).

## Errori

- Errori di scrittura del file risalgono al chiamante; gli errori di validazione o persistenza vengono propagati.

## Non fa

- Non renderizza la navigazione e non modifica slug o contenuti.
- Non salva nel database: l'aspetto del sito sta nella config del tenant, versionabile con il resto della config.
- Non svuota la cache di configurazione.
- Non valida i colori o le classi oltre a quanto fa `HeadernavData`.
