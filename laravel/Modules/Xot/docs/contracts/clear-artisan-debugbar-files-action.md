---
title: "ClearArtisanDebugbarFilesAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Artisan\\ClearArtisanDebugbarFilesAction"
qmd: "ClearArtisanDebugbarFilesAction svuota storage debugbar file json cancella artisan"
---

# ClearArtisanDebugbarFilesAction

Cancella i file JSON di Debugbar in `storage/debugbar` e restituisce un messaggio di esito. Sostituisce `ArtisanService::debugbarClear()`. Codice: `app/Actions/Artisan/ClearArtisanDebugbarFilesAction.php:13-29`.

## Input

- Nessuno (`execute()`, riga 17). Il percorso è fisso: `storage_path('debugbar')`.

## Output

- `string`: `Debugbar Storage cleared! (N Files )`, dove `N` è il numero di file trovati nella cartella (riga 27).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARTISAN-DEBUGBAR-INV-1` | Vengono cancellati solo i file con estensione `json` e percorso reale valido; la scansione non è ricorsiva. | righe 19-25 | Test: nessuno |
| `ARTISAN-DEBUGBAR-INV-2` | `N` è il conteggio di tutti i file trovati, non dei soli file cancellati. | righe 19, 27 | Test: nessuno |

## Effetti collaterali

Cancellazione fisica dei file JSON, file per file, con `File::delete`. L'esito di ogni `delete` non è controllato. Nessuna transazione, nessun evento, nessuna coda.

## Errori

- Nessuna eccezione propria.
- Dubbio: se la cartella non esiste, `File::files` potrebbe sollevare un'eccezione del Finder. Non verificato a runtime.

## Non fa

- Non cancella ricorsivamente le sottocartelle.
- Non verifica che `File::delete` sia riuscito.
- Marker `@contract` aggiunto nel docblock della classe.
