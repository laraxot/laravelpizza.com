---
title: "ApplyTenancyToPanelAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Panel\\ApplyTenancyToPanelAction"
qmd: "ApplyTenancyToPanelAction tenant pannello Filament slug tenants RegisterTenant EditTenantProfile XotData getTenantClass"
---

# ApplyTenancyToPanelAction

Configura la multi-tenancy di un pannello Filament con la classe tenant di `XotData`, registrazione e profilo del modulo User.

Codice: `app/Actions/Panel/ApplyTenancyToPanelAction.php:13-42`.

## Input

- `Panel &$panel`: pannello da configurare.

## Output

`Panel`: lo stesso pannello con tenancy configurata.

## Invarianti

- `PANEL-TEN-INV-1`: la classe tenant è quella restituita da `XotData::make()->getTenantClass()` (riga 19). Test: Nessun test dedicato.
- `PANEL-TEN-INV-2`: il tenant usa lo slug `slug` e il prefisso `tenants` (riga 32). Test: Nessun test dedicato.
- `PANEL-TEN-INV-3`: registrazione e profilo sono sempre `RegisterTenant` e `EditTenantProfile` del modulo User (righe 33-34). Test: Nessun test dedicato.
- `PANEL-TEN-INV-4`: la configurazione distinta per superadmin è commentata: tutti gli utenti ricevono la stessa configurazione (righe 21-30, 35-38). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno oltre alla mutazione del pannello.

## Errori

Nessuna eccezione propria.

## Non fa

- Dipende da `Modules\User` (dipendenza di Xot verso User: da verificare con la regola di direzione dei moduli).
