---
title: "ResolveExclusionsConfigurationAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Shield\\ResolveExclusionsConfigurationAction"
qmd: "ResolveExclusionsConfigurationAction filament-shield exclude risorse pagine widget esclusioni config"
---

# ResolveExclusionsConfigurationAction

Legge da `config/filament-shield.php` la configurazione delle esclusioni (generale, risorse, pagine, widget) e la normalizza. Codice: `app/Actions/Shield/ResolveExclusionsConfigurationAction.php`.

## Input

- Nessuno in `execute()`. I metodi pubblici `enableGeneralExclude()` e `disableGeneralExclude()` non hanno parametri.

## Output

- `execute()`: array con `general_exclude_enabled` (bool), `excluded_resources`, `excluded_pages`, `excluded_widgets` (`list<string>`).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-EXCL-INV-1` | Un valore non booleano di `exclude.enabled` diventa `true`. | `isGeneralExcludeEnabled()` | nessuno |
| `SHIELD-EXCL-INV-2` | Liste non-array diventano `[]`; gli elementi non stringa sono scartati; le chiavi sono rinumerate. | `getExcluded*()` | nessuno |

## Effetti collaterali

- `execute()`: nessuno.
- `enableGeneralExclude()` / `disableGeneralExclude()`: modificano in memoria `config('filament-shield.exclude.enabled')` per la durata della richiesta. Non scrivono su file.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non persiste le modifiche su disco.
- Nessun chiamante in produzione trovato nel perimetro cercato (Modules, app, Themes, routes, config).
