---
title: "GetAllIconsAction — contratto"
type: contract
owner: UI
status: accepted
updated: 2026-11-24
action: "Modules\\UI\\Actions\\Icon\\GetAllIconsAction"
qmd: "GetAllIconsAction icone set BladeUI svg elenco prefisso reflection"
---

# GetAllIconsAction

Elenca le icone SVG di tutti i set registrati in BladeUI Icons. Codice: `app/Actions/Icon/GetAllIconsAction.php:24-94`.

## Input

- `string $_context = 'form'`: non usato; il risultato non cambia con il contesto.

## Output

- `array<string, array<string, mixed>>`: per ogni set, i suoi dati (incluso `name`) più `icons`, l'elenco dei nomi `prefisso-nome`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `UI-ICONS-INV-1` | Se la lettura del set via reflection fallisce, restituisce `[]`. | righe 29-37 | Test: nessuno sul ramo di errore |
| `UI-ICONS-INV-2` | Sono contati solo i file con estensione `svg`. | riga 73 | `tests/Unit/GetAllIconsActionTest.php:71` |
| `UI-ICONS-INV-3` | Il nome è `prefisso-nome`, con le sottocartelle trasformate in punti e senza estensione. | righe 74-84 | `tests/Unit/GetAllIconsActionTest.php:57`, `:80` |
| `UI-ICONS-INV-4` | Ogni set nel risultato porta il proprio `name` e la lista `icons`. | righe 55, 90 | `tests/Unit/GetAllIconsActionTest.php:91`, `:100` |

## Effetti collaterali

Nessuno: sola lettura del filesystem e del container. Nessuna scrittura.

## Errori

- Il `catch (\Exception)` (righe 34-36) restituisce `[]` senza log: un errore di reflection è silenziato.

## Non fa

- Non usa cache: scansiona i file a ogni chiamata.
- Dipende dalla proprietà interna `sets` di BladeUI Icons: un cambio di versione del pacchetto rompe il risultato in silenzio.
- Il parametro `$_context` è inutilizzato.
