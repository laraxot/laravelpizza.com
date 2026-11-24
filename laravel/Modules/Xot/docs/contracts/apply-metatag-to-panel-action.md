---
title: "ApplyMetatagToPanelAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Panel\\ApplyMetatagToPanelAction"
qmd: "ApplyMetatagToPanelAction pannello Filament colori logo brand favicon MetatagData log errore"
---

# ApplyMetatagToPanelAction

Applica a un pannello Filament colori, logo, nome, favicon letti da `MetatagData`; in caso di errore logga e restituisce il pannello.

Codice: `app/Actions/Panel/ApplyMetatagToPanelAction.php:12-35`.

## Input

- `Panel &$panel`: pannello da configurare (parametro per riferimento).

## Output

`Panel`: lo stesso pannello configurato, o il pannello invariato se la configurazione fallisce.

## Invarianti

- `PANEL-META-INV-1`: imposta in catena colori, logo, nome brand, logo dark, altezza logo e favicon (righe 21-27). Test: Nessun test dedicato.
- `PANEL-META-INV-2`: un `\Exception` viene loggato con `Log::error` e il pannello è restituito senza rollback: le modifiche già applicate restano (righe 28-33). Test: Nessun test dedicato.

## Effetti collaterali

Logging di errore. Mutazione del pannello, che Filament modifica sull'istanza.

## Errori

Le eccezioni sono assorbite e loggate; gli `\Error` non sono catturati.

## Non fa

- Il parametro per riferimento non è necessario: il pannello è un oggetto.
- Non garantisce una configurazione completa in caso di errore parziale.
