---
title: "ClearArtisanErrorLogAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Artisan\\ClearArtisanErrorLogAction"
qmd: "ClearArtisanErrorLogAction svuota log storage logs laravel.log cancella artisan"
---

# ClearArtisanErrorLogAction

Cancella i file `.log` in `storage/logs` e restituisce un messaggio di esito. Sostituisce `ArtisanService::errorClear()`. Codice: `app/Actions/Artisan/ClearArtisanErrorLogAction.php:13-29`.

## Input

- Nessuno (`execute()`, riga 17). Percorso fisso: `storage_path('logs')`.

## Output

- `string`: `<pre>laravel.log cleared !</pre> (N Files )`, dove `N` è il numero di file trovati (riga 27).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARTISAN-ERRLOG-INV-1` | Vengono cancellati solo i file con estensione `log` e percorso reale valido; non ricorsivo. | righe 19-25 | Test: nessuno |
| `ARTISAN-ERRLOG-INV-2` | `N` è il conteggio di tutti i file trovati, non dei cancellati. Il messaggio nomina `laravel.log` anche se vengono cancellati altri file. | righe 19, 27 | Test: nessuno |

## Effetti collaterali

Cancellazione fisica dei `.log` con `File::delete`, senza controllo dell'esito. Nessuna transazione, nessuna coda.

## Errori

- Nessuna eccezione propria. Dubbio come per `ClearArtisanDebugbarFilesAction` se la cartella manca.

## Non fa

- Non tronca il file di log attivo: lo cancella.
- Marker `@contract` aggiunto nel docblock della classe.
