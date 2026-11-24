---
title: "PanelModuleAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\PanelModuleAction"
qmd: "PanelModuleAction configurazione modulo nwidart pannello Filament nome icona navigation_sort config Module find"
---

# PanelModuleAction

Legge la configurazione del modulo nwidart a cui appartiene un pannello Filament, con helper statici.

Codice: `app/Actions/Filament/PanelModuleAction.php:20-102`.

## Input

- `Panel $panel`: l'id del pannello è `{modulo}::{...}`.

## Output

`execute` e `config`: `array<string, mixed>`. `moduleName`: `string`. `module`: modulo nwidart. `navigationLabel`, `navigationIcon`: `string`. `navigationSort`: `int`.

## Invarianti

- `FIL-PANELMOD-INV-1`: il nome modulo è la parte dell'id del pannello prima di `::` ed è asserito non vuoto (righe 34-35). Test: Nessun test dedicato.
- `FIL-PANELMOD-INV-2`: etichetta e icona usano il default se la config manca o non è stringa: nome modulo e `heroicon-o-cube` (righe 80-95). Test: Nessun test dedicato.
- `FIL-PANELMOD-INV-3`: `navigationSort` restituisce sempre `0`, senza leggere `navigation_sort` (riga 100). Test: Nessun test dedicato.
- `FIL-PANELMOD-INV-4`: `module()` lancia se il modulo nwidart non esiste (riga 43); `moduleConfig()` lancia se il file config manca. Test: Nessun test dedicato.

## Effetti collaterali

Lettura di `config/config.php` del modulo tramite `File::getRequire`.

## Errori

`Assert` per modulo non trovato; eccezioni di `File::getRequire` per file mancante.

## Non fa

- Il docblock dice funzioni pure ma la classe usa il trait `QueueableAction`.
- Non legge `navigation_sort` dalla config.
