---
title: "Contratto — SaveFooterConfigAction"
type: contract
action: "Modules\Cms\Actions\SaveFooterConfigAction"
tags: [contract, action, cms, appearance, tenant-config]
created: 2026-11-24
updated: 2026-11-24
---

# SaveFooterConfigAction

<<<<<<< HEAD
## Input
- Un `FooterData` validato.
## Output
- Nessun valore; la configurazione viene salvata nel tenant.
## Invarianti
- Scrive la chiave `footer` nella sezione tenant `appearance`.
## Effetti collaterali
- Delega la persistenza a `SaveTenantConfigAction`.
## Errori
- Gli errori di validazione o persistenza vengono propagati.
## Non fa
- Non renderizza il footer e non modifica contenuti o traduzioni.
=======
Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/SaveFooterConfigAction.php`. Chiamante: pagina Filament
`app/Filament/Clusters/Appearance/Pages/Footer.php` (salvataggio del form).

## Input

- `FooterData`: dati del form footer (colori, classi, sfondo, ...).

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| CMS-FOOTER-SAVE-INV-1 | Scrive solo la chiave `footer` del file di config `appearance` del tenant, con `FooterData::toArray()`, delegando a `Modules\Tenant\Actions\Config\SaveTenantConfigAction`. | — |
| CMS-FOOTER-SAVE-INV-2 | Le altre chiavi di `appearance.php` restano (fusione ricorsiva in `SaveTenantConfigAction`; una lista arriva sempre completa e sostituisce la precedente). | — |

## Effetti collaterali

- Riscrive il file PHP `appearance.php` della cartella di config del tenant corrente (via `SaveTenantConfigAction` e
  `Modules\Xot\Actions\Arr\SaveArrayAction`).

## Errori

- Errori di scrittura del file risalgono al chiamante.

## Non fa

- Non salva nel database: l'aspetto del sito sta nella config del tenant, versionabile con il resto della config.
- Non svuota la cache di configurazione.
- Non valida i colori o le classi oltre a quanto fa `FooterData`.
>>>>>>> laraxot/dev
